<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ExportData
{
    public function getFileExtension() { return 'csv'; }
    public function getContentType()   { return 'text/csv'; }

    public function dump($datas)
    {
        $fp = fopen('php://temp','r+');

        // Header
        $row = array(
            "Game","Date","DOW","Time","Venue","Field",
            "Group","HT Slot","AT Slot",
            "Home Team Name",'Away Team Name',
        );
        fputcsv($fp, $row);

        // Datas is passed in
        foreach($datas as $game)
        {
            // Date/Time
            $dt   = $game->getDtBeg();
            $dow  = $dt->format('D');
            $date = $dt->format('m/d/Y');
            $time = $dt->format('g:i A');

            // Build up row
            $row = array();
            $row[] = $game->getNum();
            $row[] = $date;
            $row[] = $dow;
            $row[] = $time;
            $row[] = $game->getVenueName();
            $row[] = $game->getFieldName();

            $row[] = $game->getGroupKey();

            $row[] = $game->getHomeTeam()->getGroupSlot();
            $row[] = $game->getAwayTeam()->getGroupSlot();
            $row[] = $game->getHomeTeam()->getName();
            $row[] = $game->getAwayTeam()->getName();

            fputcsv($fp,$row);
        }
        // Return the content
        rewind($fp);
        $csv = stream_get_contents($fp);
        fclose($fp);
        return $csv;
    }
}
