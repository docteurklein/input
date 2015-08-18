<?php

namespace Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Knp\Input;
use Knp\Input\Config;

/**
 * Defines application features from the specific context.
 */
class Base implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When input is passed to main entrypoint
     */
    public function inputIsPassedToMainEntrypoint()
    {
        $this->input = Input::fromValue([
            'name' => 'florian klein',
            'address' => [
                'country' => 'france',
                'region' => 'alsace',
                'city' => 'reguisheim',
            ],
        ]);
    }

    /**
     * @Then it should accept it
     */
    public function itShouldAcceptIt()
    {
        expect($this->input->all())->toBe([
            'name' => 'florian klein',
            'address' => [
                'country' => 'france',
                'region' => 'alsace',
                'city' => 'reguisheim',
            ],
        ]);
    }

    /**
     * @Given it is configured to accept a limited subset of data based on input
     */
    public function itIsConfiguredToAcceptALimitedSubsetOfDataBasedOnInput()
    {
        $this->regions = [
            'france' => ['loire', 'alsace',],
            'germany' => ['saxe',],
        ];
        $this->cities = [
            'loire' => ['nantes',],
            'alsace' => ['reguisheim', 'colmar'],
            'saxe' => ['leipzig', 'dresden'],
        ];
        $config = new Config;
        $config
            ->name->parent()
            ->address
                ->country->accepts('france', 'germany')->parent()
                ->region->accepts()
        ;

        $config->when(function(Input $input, Config $config) {
            return $input->contains('country');
        })
        ->then(function(Config $config) {
            $config->address->region->accepts($this->regions[$this->input['country']]);
        });
        $config->when(function(Input $input, Config $config) {
            return $input->contains('region');
        })
        ->then(function(Config $config) {
            $config->address->country->accepts($this->cities[$this->input['region']]);
        });

        $this->config = $config;
    }

    /**
     * @Then it should not accept this input
     */
    public function itShouldNotAcceptThisInput()
    {
        $this->result = $this->config->handle($this->input);
        expect($this->result->extraKeys)->toHaveCount(0);
    }
}
