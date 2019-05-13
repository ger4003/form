<?php
namespace Neos\Form\Tests\Functional;

/*
 * This file is part of the Neos.Form package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */
use Neos\Flow\Mvc\Routing\Route;
use Neos\Flow\Tests\FunctionalTestCase;
use Symfony\Component\DomCrawler\Field\InputFormField;
use Symfony\Component\DomCrawler\Form;

/**
 * Testcase for Simple Form
 *
 * @group large
 */
abstract class AbstractFunctionalTestCase extends FunctionalTestCase
{
    /**
     * @var \Neos\Flow\Http\Client\Browser
     */
    protected $browser;

    /**
     * Initializer
     */
    public function setUp()
    {
        parent::setUp();

        $route = new Route();
        $route->setUriPattern('test/form/simpleform/{formFactoryClassName}');
        $route->setDefaults([
            '@package' => 'Neos.Form',
            '@subpackage' => 'Tests\Functional\Fixtures',
            '@controller' => 'Form',
            '@action' => 'index',
            '@format' => 'html'
        ]);
        $route->setAppendExceedingArguments(true);
        $this->router->addRoute($route);
    }

    /**
     * Go to the next form page
     *
     * @param Form $form
     * @return \Neos\Flow\Http\Response
     */
    protected function gotoNextFormPage(Form $form)
    {
        $nextButton = $this->browser->getCrawler()->filterXPath('//nav[@class="form-navigation"]/*/*[contains(@class, "next")]/button');
        /** @var \DOMElement $node */
        $node = $nextButton->getNode(0);
        $form->set(new InputFormField($node));

        return $this->browser->submit($form);
    }

    /**
     * Go to the previous form page
     *
     * @param Form $form
     * @return \Neos\Flow\Http\Response
     */
    protected function gotoPreviousFormPage(Form $form)
    {
        $previousButton = $this->browser->getCrawler()->filterXPath('//nav[@class="form-navigation"]/*/*[contains(@class, "previous")]/button');
        /** @var \DOMElement $node */
        $node = $previousButton->getNode(0);
        $form->set(new InputFormField($node));

        return $this->browser->submit($form);
    }
}
