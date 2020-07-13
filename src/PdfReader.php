<?php

namespace Handle\File;

use thiagoalessio\TesseractOCR\TesseractOCR;
use Symfony\Component\DomCrawler\Crawler;
use Smalot\PdfParser\Parser;
use ImalH\PDFLib\PDFLib;

class PdfReader
{
	private $path;

	private $output;

	private $created_at;

	private $total_of_pages;

	private $pages = [];

	
	public function __construct($path, $output = __DIR__.'\\..\\imagens')
	{
		if(!file_exists($path))
			throw new \Exception("Arquivo não encontrado");
			
		$this->path = $path;

		$this->output = $output;

		$this->setDetails($path);

		set_time_limit(180);

		$total_of_pages = $this->scan();

		$this->pages = $this->appendPages($total_of_pages);
	}
	

	/**
	 * Build parse object and parse pdf file
	 * @return Object parser
	 */

	public function Parser()
	{
		$parser = new Parser();

		return $parser->parseFile($this->path);
	}
	

	/**
	 * Build necessary objects and set PDF details
	 * @param string $path
	 */

	public function setDetails($path)
	{
		$pdf = $this->Parser($path);

		$details = $pdf->getDetails();

		$this->total_of_pages = $details['Pages'];

		$this->created_at = (
			new \DateTime(
				$details['CreationDate']
			))->format('d/m/Y');
	}


	/**
	 * Retrieve any attribute from the pdf object
	 * @param Attribute name
	 * @return Attribute value
	 */

	public function __get($attribute)
	{
		return $this->$attribute;
	}

	/**
	 * Convert a pdf to an image
	 * @return integer $totalOfPages
	 */

	public function scan()
	{
		$path = $this->path;
		$output = $this->output;

		$pdflib = new PDFLib();
		$pdflib->setPdfPath($path);
		$pdflib->setOutputPath($output);
		$pdflib->setImageFormat(PDFLib::$IMAGE_FORMAT_PNG);
		$pdflib->setDPI(300);
		$pdflib->setPageRange(1,$pdflib->getNumberOfPages());
		
		$pdflib->convert();

		return $totalOfPages = $pdflib->getNumberOfPages();
	}

	/**
	 * Scan all the images to append the pages
	 * @param integer $totalOfPages
	 * @return all or a single the page
	 */

	public function appendPages($totalOfPages)
	{
		$pages = [];

		for ($i=1; $i <= $totalOfPages; $i++) { 

			$pages[] = (new TesseractOCR($this->output.'\page-'.$i.'.png'))->lang('por')->run();

		};

		PdfReader::eraseImages($this);

		return $pages;
	}

	public static function eraseImages(PdfReader $pdf)
	{
		array_map('unlink', glob($pdf->output.'\*.png'));
	}

}
