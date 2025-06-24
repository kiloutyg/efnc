import { Controller } from '@hotwired/stimulus';

export default class PictureManagementController extends Controller {

    static targets = ['pictureDisablerToggle'];

    connect() {
        console.log('Connected to picture management controller');
    }


}