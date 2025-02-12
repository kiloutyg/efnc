#!/bin/bash

# Get the github user and the podman from the argument
GITHUB_USER=$1
PODMAN=$2

echo "github user: ${GITHUB_USER}"
echo "podman: ${PODMAN}"

# Ask the user if they have already run the app
while true; do
read -p "Are you running the app for the first Time ? (yes/no) " ANSWER;
# Check if the user answered yes or no
    if [ "${ANSWER}" == "yes" ] || [ "${ANSWER}" == "no" ]; then 
        break
        else
            echo "Please answer by yes or no";
    fi
done

sudo yum install -y git yum-utils;

# If the user answered yes, we install the app
if [ "${ANSWER}" == "yes" ]; then 

    # Ask the user for the git repository address either in ssh or http
    read -p "Address of the git repository (default: https://github.com/${GITHUB_USER}/efnc ) :  " GIT_ADDRESS;
    if [ -z "${GIT_ADDRESS}" ]
    then
        GIT_ADDRESS="https://github.com/${GITHUB_USER}/efnc"
    fi


    # Clone the git repository and run the env_create.sh script
    git clone ${GIT_ADDRESS};

    cd efnc;

    if [ "${PODMAN}" == "no" ]; then

        # Function to check for uppercase characters
        contains_uppercase() {
            [[ "$1" =~ [A-Z] ]]
        }

        # Install git and PlasticOmnium docker repo
        sudo yum-config-manager --add-repo https://download.docker.com/linux/rhel/docker-ce.repo;

        # Remove old docker version and install docker-ce
        sudo yum remove docker \
                    docker-client \
                    docker-client-latest \
                    docker-common \
                    docker-latest \
                    docker-latest-logrotate \
                    docker-logrotate \
                    docker-engine \
                    podman \
                    runc;

        sudo yum install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin -y;

        # Add the user to the docker group
        sudo groupadd docker;
        sudo usermod -aG docker $USER;

        # Connect to the github docker registry
        # docker login ghcr.io -u $GITHUB_USER -p $GITHUB_TOKEN;

        # Start docker and enable it inside a prompt with the docker group
        sg docker -c "
            sudo systemctl start docker;
            sudo systemctl start containerd.service;
            sudo systemctl enable docker.service;
            sudo systemctl enable containerd.service;"

        bash ./env_create_docker.sh ${GITHUB_USER};

        # Build the docker containers
        sg docker -c "docker compose up --build -d"

    else

        bash ./env_create_podman.sh ${GITHUB_USER};

        podman play kube --replace ./efnc.yml;

    fi

else

# If the user answered no, we will ask if he wants to launch the app or if he wants to update it
while true; do
    read -p "Do you wish to launch the app ? (yes/no) " LAUNCH_ANSWER;
    if [ "${LAUNCH_ANSWER}" == "yes" ] || [ "${LAUNCH_ANSWER}" == "no" ]; then
        break
        else
            echo "Please answer by yes or no";
    fi
done

# If the user answered yes, we launch the app
    if [ "${LAUNCH_ANSWER}" == "yes" ]; then
        cd efnc;
        if [ "${PODMAN}" == "no" ]; then
            sg docker -c "docker compose up -d"
        else
            podman play kube --replace ./efnc.yml;
        fi
    else
        while true; do
            read -p "Do you wish to update the app ? (yes/no) " UPDATE_ANSWER;
            if [ "${UPDATE_ANSWER}" == "yes" ] || [ "${UPDATE_ANSWER}" == "no" ]; then
                break
                else
                    echo "Please answer by yes or no";
            fi
        done

        if [ "${UPDATE_ANSWER}" == "yes" ]; then

            # Function to check for uppercase characters
            contains_uppercase() {
                [[ "$1" =~ [A-Z] ]]
            }

        # Ask the user for the git repository address either in ssh or http
            read -p "Address of the git repository (default: https://github.com/${GITHUB_USER}/efnc ) :  " GIT_ADDRESS;
            if [ -z "${GIT_ADDRESS}" ]
            then
                GIT_ADDRESS="https://github.com/${GITHUB_USER}/efnc"
            fi
            cd efnc;

            if [ "${PODMAN}" == "no" ]; then
            sg docker -c "docker compose stop";
                sg docker -c "docker system prune -fa";
            else
                podman play kube --down ./efnc.yml;
                podman system prune -fa;
            fi

            git remote remove origin;
            # Remove everything before https in the GIT_ADDRESS
            GIT_ADDRESS=$(echo ${GIT_ADDRESS} | sed 's|.*\(https\)|\1|')

            git remote add origin ${GIT_ADDRESS};
            git fetch origin --force;
            git reset --hard origin/main;
            git pull --rebase origin main;

            if [ "${PODMAN}" == "no" ]; then
                bash ./env_update_docker.sh ${GITHUB_USER};
                sg docker -c "docker compose up --build -d"
                # Wait until the webpack compiled successfully
                until docker compose logs --since 10s --tail 10 web 2>&1 | grep -q "webpack compiled successfully"; do
                    echo "Waiting for the app to be updated" 
                    sleep 10
                done
                echo "EFNC updated successfully";
            else
                bash ./env_update_podman.sh ${GITHUB_USER};
                podman play kube --replace ./efnc.yml;
                # Wait until the webpack compiled successfully
                until podman logs --since 10s --tail 10 web-docauposte 2>&1 | grep -q "webpack compiled successfully"; do
                echo "Waiting for the app to be updated" 
                sleep 10
                done
                echo "EFNC updated successfully";

            fi
        fi
    fi
fi
