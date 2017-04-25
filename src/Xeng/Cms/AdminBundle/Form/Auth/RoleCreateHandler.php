<?php

// src/Xeng/Cms/AdminBundle/Form/Auth/RoleCreateHandler.php

namespace Xeng\Cms\AdminBundle\Form\Auth;

use Xeng\Cms\CoreBundle\Form\FormHandler;
use Respect\Validation\Validator as v;
use Xeng\Cms\CoreBundle\Services\Auth\XRoleManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * create role form handler
 */
class RoleCreateHandler extends FormHandler {

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        if(!$this->isSubmitted()){
            return;
        }
        $name=$this->createParamValidationResult('name');
        $this->createParamValidationResult('description');
        $this->createParamValidationResult('enabled');

        $nameValidator=v::allOf(
            $this->notEmpty,
            v::alnum()
        );
        if(!$nameValidator->validate($name->getValue())){
            $this->addError($name,'Name not valid, must be alphanumeric');
            return;
        }

        /** @var XRoleManager $xRoleManager */
        $xRoleManager = $this->container->get('xeng.role_manager');

        if($xRoleManager->roleNameExists($name->getValue())){
            $this->addError($name,'Role name already exists');
            return;
        }

    }
}