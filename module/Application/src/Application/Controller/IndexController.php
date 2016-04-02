<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\User\Form\UserLoginForm;
use Application\Model\User\Form\InputFilter\UserLoginInputFilterFactory;
use Application\Model\User\Authorization\Authorization;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new UserLoginForm();
        
        $request = $this->getRequest();
        
        $form->get('login')->setLabel("test");
        
        $label = $form->get('login')->getLabel();
        
        $form->get('login')->setOptions(array(
            'label_class' => array('class' => 'control-label')
        ));
        
        if($request->isPost()){
            $data = $request->getPost();
           
            $form->setInputFilter(UserLoginInputFilterFactory::createInputFilter());
            $form->setData($data);            
            
            if($form->isValid()){
                $authorization = new Authorization();
                
                $authorization->setAuthAdapter($this->getServiceLocator()->get('LoginService'));
                
                $result = $authorization->login('test', 'test');
                
                var_dump($result);
            }
        }
        
        return new ViewModel(array('form' => $form));
    }
}
