<?php
require("api/libs/tfpdf/tfpdf.php");

class PDF extends TFPDF
{
    function Header()
    {
        $this->AddFont('DejaVu','','DejaVuSerif.ttf',true);
        $this->SetFont('DejaVu','',14);

        $this->Cell(80);
        $this->Cell(45,15,'FilmZone Report',0,0,'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Strana '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function generujPDF($product_arr){

        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Times','',12);
        $this->SetFont('DejaVu','',12);
        $this->Cell(0,10,$product_arr["nazovFilmu"],1,1,'C');

        $this->MultiCell(0,10,$product_arr["popisFilmu"],"T");

        $this->Cell(0,10,"Kategoria: ".$product_arr["kategoria"]."//"."Datum premiery SR ".$product_arr["datumPremierySR"],1,1,'C');
        $this->ln();


        if(sizeof($product_arr["Obsadenie"])>0){
            $w = array(20, 50, 60,60);
            $header = array("#","Pozicia", "Meno","Priezvisko");

            $this->SetFillColor(169,169,169);

            for($i=0;$i<4;$i++)
                $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
            $this->Ln();

            $this->SetFillColor(224,235,255);

            foreach($product_arr["Obsadenie"] as $row)
            {
                $this->Cell($w[0],6,number_format($row["idObsadenia"]),'LRDB',0,'C');
                $this->Cell($w[1],6,$row["pozicia"],'LRDB',0,'C');
                $this->Cell($w[2],6,$row["meno"],'LRDB',0,'C');
                $this->Cell($w[3],6,$row["priezvisko"],'LRDB',0,'C');
                $this->Ln();
            }
        }
        $this->Output();






    }
}
