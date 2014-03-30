<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 * 
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento ENTERPRISE edition
 * aheadWorks does not guarantee correct work of this extension
 * on any other Magento edition except Magento ENTERPRISE edition.
 * aheadWorks does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Blog
 * @copyright  Copyright (c) 2009-2010 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 */
class AW_Blog_Model_Observer
{
    public function addBlogSection($observer)
    {
            $sitemapObject = $observer->getSitemapObject();
            if (!($sitemapObject instanceof Mage_Sitemap_Model_Sitemap))
                throw new Exception(Mage::helper('blog')->__('Error during generation sitemap'));
            
            $storeId = $sitemapObject->getStoreId();
            $date    = Mage::getSingleton('core/date')->gmtDate('Y-m-d');
            $baseUrl = Mage::app()->getStore($storeId)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
            /**
             * Generate blog pages sitemap
             */
            $changefreq = (string)Mage::getStoreConfig('sitemap/blog/changefreq');
            $priority   = (string)Mage::getStoreConfig('sitemap/blog/priority');
            $collection = Mage::getModel('blog/blog')->getCollection()->addStoreFilter($storeId);
            Mage::getSingleton('blog/status')->addEnabledFilterToCollection($collection);
            $route = Mage::getStoreConfig('blog/blog/route');
            if ($route == "") {
               $route = "blog";
            }
                        
            /* free clinic state */
            
            $locs = Mage::getModel('localepage/dynamic')->getCollection();
            $locs->addFieldToFilter('type',array('eq'=>'free'));
            $locs->getSelect()->group('state');
            
            $xml = sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%.1f</priority></url>',
                    htmlspecialchars(strtolower($baseUrl.'free-std-clinics')),
                    $date,
                    $changefreq,
                    $priority
                );
            
            $sitemapObject->sitemapFileAddLine($xml);
            
            $xml = sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%.1f</priority></url>',
                    htmlspecialchars(strtolower($baseUrl.'std-test-centers')),
                    $date,
                    $changefreq,
                    $priority
                );
            
            $sitemapObject->sitemapFileAddLine($xml);
                        
            foreach ($locs->getItems() as $loc) {
            
            	//print_r($item->getData()); exit();
            
            	$xml = sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%.1f</priority></url>',
                    htmlspecialchars(strtolower($baseUrl.'free-std-clinics/'.str_replace(' ','-',$loc->getData('stateFull')).'-'.$loc->getState())),
                    $date,
                    $changefreq,
                    $priority
                );
            
            $sitemapObject->sitemapFileAddLine($xml);
            
            }
            
             /* free clinic state / city  */
             
            $locs = Mage::getModel('localepage/dynamic')->getCollection();
            $locs->addFieldToFilter('type',array('eq'=>'free'));
            $locs->getSelect()->group(array('state','city'));
  
            foreach ($locs->getItems() as $loc) {
                        
            	$xml = sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%.1f</priority></url>',
                    htmlspecialchars(strtolower($baseUrl.'free-std-clinics/'.str_replace(' ','-',$loc->getData('stateFull')).'-'.$loc->getState().'/'.str_replace(' ','-',$loc->getCity()))),
                    $date,
                    $changefreq,
                    $priority
                );
            
            $sitemapObject->sitemapFileAddLine($xml);
            
            }
            
            /* free clinic state / city / location */
            
            $locs = Mage::getModel('localepage/dynamic')->getCollection();
            $locs->addFieldToFilter('type',array('eq'=>'free'));
            $locs->getSelect()->group(array('state','city','dynamic_id'));
  
            foreach ($locs->getItems() as $loc) {
                        
            	$xml = sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%.1f</priority></url>',
                    htmlspecialchars(strtolower($baseUrl.'free-std-clinics/'.str_replace(' ','-',$loc->getData('stateFull')).'-'.$loc->getState().'/'.str_replace(' ','-',$loc->getCity()).'/'.$loc->getDynamicId().'-'.$loc->getZip())),
                    $date,
                    $changefreq,
                    $priority
                );
            
            $sitemapObject->sitemapFileAddLine($xml);
            
            }
            
            
            
            
            /* paid clinic state */
            
            $locs = Mage::getModel('localepage/dynamic')->getCollection();
            $locs->addFieldToFilter('type',array('eq'=>'normal'));
            $locs->getSelect()->group('state');
                        
            foreach ($locs->getItems() as $loc) {
            
            	//print_r($item->getData()); exit();
            
            	$xml = sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%.1f</priority></url>',
                    htmlspecialchars(strtolower($baseUrl.'std-test-centers/'.str_replace(' ','-',$loc->getData('stateFull')).'-'.$loc->getState())),
                    $date,
                    $changefreq,
                    $priority
                );
            
            $sitemapObject->sitemapFileAddLine($xml);
            
            }
            
             /* paid clinic state / city  */
             
            $locs = Mage::getModel('localepage/dynamic')->getCollection();
            $locs->addFieldToFilter('type',array('eq'=>'normal'));
            $locs->getSelect()->group(array('state','city'));
  
            foreach ($locs->getItems() as $loc) {
                        
            	$xml = sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%.1f</priority></url>',
                    htmlspecialchars(strtolower($baseUrl.'std-test-centers/'.str_replace(' ','-',$loc->getData('stateFull')).'-'.$loc->getState().'/'.str_replace(' ','-',$loc->getCity()))),
                    $date,
                    $changefreq,
                    $priority
                );
            
            $sitemapObject->sitemapFileAddLine($xml);
            
            }
            
            /* paid clinic state / city / location */
            
            $locs = Mage::getModel('localepage/dynamic')->getCollection();
            $locs->addFieldToFilter('type',array('eq'=>'normal'));
            $locs->getSelect()->group(array('state','city','dynamic_id'));
  
            foreach ($locs->getItems() as $loc) {
                        
            	$xml = sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%.1f</priority></url>',
                    htmlspecialchars(strtolower($baseUrl.'std-test-centers/'.str_replace(' ','-',$loc->getData('stateFull')).'-'.$loc->getState().'/'.str_replace(' ','-',$loc->getCity()).'/'.$loc->getDynamicId().'-'.$loc->getZip())),
                    $date,
                    $changefreq,
                    $priority
                );
            
            $sitemapObject->sitemapFileAddLine($xml);
            
            }
            
            
            /* localepage content */
            
            $locs = Mage::getModel('localepage/localepage')->getCollection();
                        
            foreach ($locs->getItems() as $loc) {
                        
            	$xml = sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%.1f</priority></url>',
                    htmlspecialchars(strtolower($baseUrl.$loc->getUrlKey())),
                    $date,
                    $changefreq,
                    $priority
                );
            
            $sitemapObject->sitemapFileAddLine($xml);
            
            }
            
            
            /* blog */
            
            foreach ($collection as $item) {
                $xml = sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%.1f</priority></url>',
                    htmlspecialchars($baseUrl . $item->getIdentifier()),
                    $date,
                    $changefreq,
                    $priority
                );

                $sitemapObject->sitemapFileAddLine($xml);
            }
            unset($collection);
            
            
            
    }
}