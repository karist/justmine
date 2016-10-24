<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LayoutMasterSet extends Model
{
	private $layoutmaster = '', $regionbody='', $regionbefore='', $regionafter='', $pagemaster='';
	private $top, $bottom, $inside, $outside, $mirror, $headermargin, $footermargin;

    function __construct($top, $bottom, $inside, $outside, $mirror, $headermargin, $footermargin, $papersize) {
    	$this->top = $top;
        $this->bottom = $bottom;
        $this->inside = $inside;
        $this->outside = $outside;
        $this->mirror = $mirror;
        $this->headermargin = $headermargin;
        $this->footermargin = $footermargin;
        $this->papersize = $papersize;
        $this->setLayoutMaster();
   	}

   	function setLayoutMaster(){
   		$this->setPageMaster();
   		$this->setRegionBody();
   		$this->setRegionBefore();
   		$this->setRegionAfter();
   		$layoutmaster = '<fo:layout-master-set>'.$pagemaster.$regionbody.$regionbefore.$regionafter.'</fo:simple-page-master></fo:layout-master-set>';
   	}

   	function getLayoutMaster(){
   		return $layoutmaster;
   	}

   	function setPageMaster(){
   		if($papersize = 'A5'){
   			$pagemaster = '<fo:simple-page-master master-name="all" margin-left="'.$outside.'mm" margin-right="'.$inside.'mm" margin-top="'.$top.'mm" margin-bottom="'.$bottom.'mm" page-height="21cm" page-width="14.8cm">';
   		}
   		
   	}

   	function getPageMaster(){
   		return $pagemaster;
   	}

   	function getRegionBody(){
   		return $regionbody;
   	}

   	function setRegionBody(){
   		$regionbody = '<fo:region-body region-name="body"/>';
   	}

   	function getRegionBefore(){
   		return $regionbefore;
   	}

   	function setRegionBefore(){
   		$regionbefore = '<fo:region-before extent="'.$headermargin.'mm" region-name="odd-header" /></fo:simple-page-master>';
   	}

   	function getRegionAfter(){
   		return $regionafter;
   	}

   	function setRegionAfter(){
   		if(mirror){
   			$regionafter = '<fo:region-after extent="'.$footermargin.'mm" region-name="footer" />';
   		} else {
   		}
   	}
}
