<?php 

class Barcode
{
	
	function __construct()
	{
		require_once(APPPATH . '/third_party/barcode/vendor/autoload.php');
	}

	public function generate($barcode)
	{
		$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
		return $generator->getBarcode($barcode, $generator::TYPE_CODE_128);
	}
}
?>