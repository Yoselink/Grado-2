<?php
require_once '../vendor/mpdf/mpdf.php';
require_once '../funciones/conex.php';
/**
 * Create a new PDF document
 *
 * @param string $mode
 * @param string $format
 * @param int $font_size
 * @param string $font
 * @param int $margin_left
 * @param int $margin_right
 * @param int $margin_top (Margin between content and header, not to be mixed with margin_header - which is document margin)
 * @param int $margin_bottom (Margin between content and footer, not to be mixed with margin_footer - which is document margin)
 * @param int $margin_header
 * @param int $margin_footer
 * @param string $orientation (P, L)
 */

class Pdf_salidas{
  private $pdf;
  private $fecha;
  private $salida;

  public function __CONSTRUCT()
  {
    $this->salida = new \Funciones\Salidas();
    $this->fecha = date("d-m-Y");
  }

  public function salida($id)
  {
    $body = "";
    $salida = $this->salida->obtener($id);
    if($salida){

      $body.="
            <div class='col-12'>
              <b>Salida #{$salida->id_salida}</b><br>
              <small>Registrada {$salida->registrado}</small>
            </div>
            <div class='col-6'>
              <h4>Datos del usuario</h4>
              <strong>{$salida->nombre} {$salida->apellido}</strong><br>
              Cedula: {$salida->cedula}<br>
              Email: {$salida->email}<br>
            </div>
            <div class='col-12'> &nbsp; </div>
            <div class='col-12'>
              <h4>Datos de la salida</h4>
              {$salida->contenido}<br>
              <b>Cantidad:</b> {$salida->cantidad}
            </div>
          ";

    }else{
      $name="";
      $body = "<center> <h1>Ha ocurrido un error.</h1></cener>";
    }//Si existe un error

    $mpdf = new mPDF('','', 12, '', 15, 15, 0, 5, 5, 5, 'P');
    
    $header = "
              <div class='col-3'>
              </div>
              <div class='col-6 text-center'>
                <h4>INVERPARTS DEL TUY</h4>
              </div>";
    $footer = "
            <table width=\"100%\" style=\"vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;\"><tr>
            <td width=\"33%\"><span style=\"font-weight: bold; font-style: italic;\">{DATE m-d-Y}</span></td>
            <td width=\"33%\" align=\"center\" style=\"font-weight: bold; font-style: italic;\">{PAGENO}/{nbpg}</td>
            <td width=\"33%\" style=\"text-align: right; \">SALIDA #{$id}</td>
            </tr></table>";
    $css = "
    body{box-sizing: border-box;font-family: 'Source Sans Pro',sans-serif;}
    table{border-spacing: 0;border-collapse: collapse;}
    .table td,.table th {background-color: #fff !important;}
    .table-bordered th,.table-bordered td {border: 1px solid #ddd !important;}
    .table { width: 100%; max-width: 100%; margin-bottom: 20px; }
    .table th,
    .table td { padding: 8px;border-top: 1px solid #ddd; }
    .table tbody td{font-size:13px}
    .table thead tr th { vertical-align: bottom; border-bottom: 2px solid #ddd; }
    .text-center{text-align:center}.text-left{text-align:left;}.text-right{text-align:right}
    .col-1,.col-2,.col-3,.col-4,.col-5,.col-6,.col-7,.col-8,.col-9,.col-10,.col-11,.col-12{position:relative;float:left;min-height:1px;padding:5px 15px 2px 15px;margin:0;overflow:hidden;}
    .col-1{width:3.87%;}.col-2{width:12.21%;}.col-3{width:20.54%;}.col-4{width:28.87%;}.col-5{width:37.21%;}.col-6{width:45.54%;}
    .col-7{width:53.87%;}.col-8{width:62.21%;}.col-9{width:70.54%;}.col-10{width:78.87%;}.col-11{width:87.21%;}.col-12{width:100%;}
    p{font-size:16px} .under{border-bottom:1px solid #000}.b{font-weight:bold}";

    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->setAutoBottomMargin = 'stretch';
    $mpdf->SetHTMLHeader($header);
    $mpdf->SetHTMLFooter($footer);
    $mpdf->WriteHTML($css,1);
    $mpdf->WriteHTML($body,2);
    $mpdf->Output("salida_{$id}.pdf","D");
  }//Order
}//Pdf_electores

$pdf = new \Pdf_salidas();

if(isset($_GET['action'])):
  switch ($_GET['action']):
    case 'salida':
      $id = $_GET['id'];
      $pdf->salida($id);
    break;
    default:
      return false;
    break;
  endswitch;
endif;
?>