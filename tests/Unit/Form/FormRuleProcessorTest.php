<?php
namespace Tests\Boekkooi\Bundle\JqueryValidationBundle\Unit\Form;

use Boekkooi\Bundle\JqueryValidationBundle\Form\FormRuleContextBuilder;
use Boekkooi\Bundle\JqueryValidationBundle\Form\FormRuleProcessor;
use Boekkooi\Bundle\JqueryValidationBundle\Form\FormRuleProcessorContext;
use Boekkooi\Bundle\JqueryValidationBundle\Form\FormRuleProcessorInterface;

/**
 * @author Warnar Boekkooi <warnar@boekkooi.net>
 */
class FormRuleProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provide_invalid_construct_arguments
     */
    public function construct_should_only_accept_a_array_of_processors($invalid)
    {
        try {
            new FormRuleProcessor($invalid);
        } catch (\TypeError $e) {
            return;
        } catch (\PHPUnit_Framework_Error $e) {
            return;
        } catch (\InvalidArgumentException $e) {
            return;
        }

        $this->fail('Expected a PHP exception or InvalidArgumentException');
    }

    public function provide_invalid_construct_arguments()
    {
        return array(
            array(new \stdClass()),
            array(array(new \stdClass())),
            array(array(false)),
            array(array(null)),
            array(array('string')),
        );
    }

    /**
     * @test
     */
    public function process_should_forward_to_all_processors()
    {
        $processContext = $this->getMockBuilder(FormRuleProcessorContext::class)
            ->disableOriginalConstructor()->getMock();
        $formRuleContext = $this->getMockBuilder(FormRuleContextBuilder::class)
            ->disableOriginalConstructor()->getMock();

        $processor1 = $this->getMock(FormRuleProcessorInterface::class);
        $processor1->expects($this->once())->method('process')->with($processContext, $formRuleContext);
        $processor2 = $this->getMock(FormRuleProcessorInterface::class);
        $processor2->expects($this->once())->method('process')->with($processContext, $formRuleContext);

        $SUT = new FormRuleProcessor(array(
            $processor1,
            $processor2,
        ));

        $SUT->process($processContext, $formRuleContext);
    }
}
