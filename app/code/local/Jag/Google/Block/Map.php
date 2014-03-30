<?php

class Jag_Google_Block_Map extends Mage_Core_Block_Template
{
    protected $_markers = null;

    public function _construct()
    {
        $this->setMapWidth(Mage::helper('jag_google')->getMapWidth());
        $this->setMapHeight(Mage::helper('jag_google')->getMapHeight());

        $this->setMapLat(null);
        $this->setMapLong(null);

        $this->_markers = array();
    }

    public function addMarker($marker_lat, $marker_long)
    {
        $this->_markers[] = array('marker_lat' => $marker_lat, 'marker_long' => $marker_long);
    }

    public function getMarkerLocations()
    {
        return $this->_markers;
    }

    public function canShowMap()
    {
        return
            (is_numeric($this->getMapWidthValue()) && is_numeric($this->getMapHeightValue()))
            &&
            (($this->getMapWidthValue() > 0) && ($this->getMapHeightValue() > 0))
            &&
            (is_numeric($this->getMapLatitude()) && is_numeric($this->getMapLongitude()));
    }
    
    public function getMapWidthValue()
    {
        return $this->getMapWidth();
    }

    public function getMapHeightValue()
    {
        return $this->getMapHeight();
    }

    public function getMapApiKey()
    {
        return Mage::helper('jag_google')->getMapApiKey();
    }

    public function getMapLatitude()
    {
        return floatval($this->getMapLat());
    }

    public function getMapLongitude()
    {
        return floatval($this->getMapLong());
    }
}
