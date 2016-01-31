<?php
/**
 * @category   Shopware
 * @package    Shopware_Plugins_Frontend_PprRefreshAmount
 * @version    $Id$
 * @author     Patrick Prädikow
 */
use Doctrine\Common\Collections\ArrayCollection;

class Shopware_Plugins_Frontend_PprRefreshAmount_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{

	protected function createForm()
    {
        $form = $this->Form();
		
    }
 
    public function getCapabilities()
    {
        return array(
            'install' => true,
            'enable' => true,
            'update' => true
        );
    }
 
    public function getLabel()
    {
        return 'Anzeige der Warenkorb-Summe beim Öffnen des Shops aktualisieren';
    }

    public function getVersion()
    {
        return "1.0.0";
    }
 
    public function getInfo() {
        return array(
			'author' => 'Patrick Prädikow',
            'version' => $this->getVersion(),
            'copyright' => 'Copyright (c) 2015, Patrick Prädikow',
            'label' => $this->getLabel(),
            //'description' => file_get_contents($this->Path() . 'info.txt'),
            'support' => 'http://forum.shopware.de',
            'link' => 'http://shopware.pradikow.de',
			'source' => 'Community',
            'changes' => array(
                '1.0.0'=>array('releasedate'=>'2015-10-30', 'lines' => array(
                    'Erstes Release'
                ))
            ),
            //'revision' => '2'
        );
    }

    public function update($version)
    {
        return true;
    }
 
    public function install()
    {
        $this->subscribeEvents();
		$this->createForm();	

		$cacheManager = Shopware()->Container()->get('shopware.cache_manager');
		//$cacheManager->clearHttpCache();
		$cacheManager->clearThemeCache();
		
        return true;
    }
 
    public function uninstall()
    {
		$cacheManager = Shopware()->Container()->get('shopware.cache_manager');
		$cacheManager->clearThemeCache();
		$this->secureUninstall();
        return true;
    }
	
    public function secureUninstall()
    {
        return true;
    }
	
	/**
	 * Registers all necessary events and hooks.
	 */
	private function subscribeEvents()
	{
		// Subscribe the needed event for less merge and compression
        $this->subscribeEvent(
            'Theme_Compiler_Collect_Plugin_Javascript',
            'addJavascriptFiles'
        );
	}

    /**
     * Provides an ArrayCollection for js compressing
     * @param Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function addJavascriptFiles(\Enlight_Event_EventArgs $args)
    {
        $js = __DIR__ . '/Views/Responsive/frontend/_public/src/js/PprRefreshAmount.js';
 
        return new ArrayCollection(array($js));
 
    }
}


