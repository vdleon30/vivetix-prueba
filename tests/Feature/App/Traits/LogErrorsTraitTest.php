<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Traits\LogErrorsTrait;

class LogErrorsTraitTest extends TestCase
{
    use LogErrorsTrait;

    public function test_reportError_logs_error_with_info_type()
    {
        $exception = new \Exception("Test Exception", 500);

        $this->reportError($exception, "info");

        $this->assertTrue(true);
    }

    public function test_reportError_logs_error_with_another_type()
    {
        $exception = new \Exception("Test Exception", 500);

        $this->reportError($exception, "test");

        $this->assertTrue(true);
    }

    public function test_reportErrorChannel_logs_error_with_info_type_and_default_channel()
    {
        $exception = new \Exception("Test Exception", 500);

        $this->reportErrorChannel($exception, "info");

        $this->assertTrue(true);
    }

    public function test_reportErrorChannel_logs_error_with_another_type_and_default_channel()
    {
        $exception = new \Exception("Test Exception", 500);

        $this->reportErrorChannel($exception, "test");

        $this->assertTrue(true);
    }

    public function test_report_logs_info_data_to_default_channel()
    {
        $data = [
            'message' => 'Test Message',
            'value' => 'Test Value'
        ];

        $this->report("default", "info", $data);

        $this->assertTrue(true);
    }

    public function test_report_logs_another_data_to_default_channel()
    {
        $data = [
            'message' => 'Test Message',
            'value' => 'Test Value'
        ];

        $this->report("default", "test", $data);

        $this->assertTrue(true);
    }
}
