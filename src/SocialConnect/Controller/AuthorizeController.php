<?php
namespace SocialConnect\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AuthorizeController extends AbstractActionController
{
    public function facebookAction()
    {
        /* @var $facebook \SocialConnect\Service\FacebookService */
        $facebook = $this->getServiceLocator()->get('facebookConnect');

        $urlData = $facebook->getReturnUrlData();
        //var_dump($facebook);
        //exit;
        
        return $this->redirect()->toUrl(
            $facebook->getLoginUrl(
                $this->url()->fromRoute($urlData['routeName'], $urlData['params'], array('force_canonical' => true))
            )
        );
    }

    public function twitterAction()
    {
        /* @var $twitter \SocialConnect\Service\TwitterService */
        $twitter = $this->getServiceLocator()->get('twitterConnect');

        $urlData = $twitter->getReturnUrlData();

        return $this->redirect()->toUrl(
            $twitter->getLoginUrl(
                $this->url()->fromRoute($urlData['routeName'], $urlData['params'], array('force_canonical' => true))
            )
        );
    }
}