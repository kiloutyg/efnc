<?php
namespace App\Controller;

use App\Entity\EFNC;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExportController extends AbstractController
{
    #[Route('/export-csv', name: 'export_csv')]
    public function exportCSV(EntityManagerInterface $em): Response
    {
        // Retrieve all EFNC entries from the database
        $efncs = $em->getRepository(EFNC::class)->findAll();

        // Open a memory "file" for CSV output
        $handle = fopen('php://memory', 'r+');

        // Define the CSV header row
        $headers = [
            'ID',
            'Title',
            'Creator',
            'DetectionDate',
            'Quantity',
            'QuantityToBlock',
            'DetailedDescription',
            'CreatedAt',
            'UpdatedAt',
            'SAPReference',
            'Status',
            'ClosedDate',
            'Archiver',
            'DetectionTime',
            'Team',
            'Project',
            'UAP',
            'DetectionPlace',
            'NonConformityOrigin',
            'AnomalyType',
            'RiskWeighting',
            'Product',
            'Archived',
            'LastModifier',
            'ArchivingCommentary',
            'Closer',
            'ClosingCommentary'
        ];
        fputcsv($handle, $headers);

        // Loop through each EFNC and write a CSV row
        foreach ($efncs as $efnc) {
            $row = [
                $efnc->getId(),
                $efnc->getTitle(),
                $efnc->getCreator(),
                $efnc->getDetectionDate() ? $efnc->getDetectionDate()->format('Y-m-d') : '',
                $efnc->getQuantity(),
                $efnc->getQuantityToBlock(),
                $efnc->getDetailedDescription(),
                $efnc->getCreatedAt() ? $efnc->getCreatedAt()->format('Y-m-d H:i:s') : '',
                $efnc->getUpdatedAt() ? $efnc->getUpdatedAt()->format('Y-m-d H:i:s') : '',
                $efnc->getSAPReference(),
                $efnc->getStatus() !== null ? ($efnc->getStatus() ? 'true' : 'false') : '',
                $efnc->getClosedDate() ? $efnc->getClosedDate()->format('Y-m-d H:i:s') : '',
                $efnc->getArchiver(),
                $efnc->getDetectionTime() ? $efnc->getDetectionTime()->format('H:i:s') : '',
                $efnc->getTeam() ? $efnc->getTeam()->getName() : '',
                $efnc->getProject() ? $efnc->getProject()->getName() : '',
                $efnc->getUap() ? $efnc->getUap()->getName() : '',
                $efnc->getDetectionPlace() ? $efnc->getDetectionPlace()->getName() : '',
                $efnc->getNonConformityOrigin() ? $efnc->getNonConformityOrigin()->getName() : '',
                $efnc->getAnomalyType() ? $efnc->getAnomalyType()->getName() : '',
                $efnc->getRiskWeighting() ? $efnc->getRiskWeighting()->getWeight() : '',
                $efnc->getProduct() ? $efnc->getProduct()->getName() : '',
                $efnc->getArchived() !== null ? ($efnc->getArchived() ? 'true' : 'false') : '',
                $efnc->getLastModifier(),
                $efnc->getArchivingCommentary(),
                $efnc->getCloser(),
                $efnc->getClosingCommentary(),
            ];

            fputcsv($handle, $row);
        }

        // Rewind the "file" so we can read its content
        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        // Create a response with CSV headers for download
        $response = new Response($csvContent);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'efnc_export.csv'
        );
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
