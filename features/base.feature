Feature: Handling submitted input
    In order to facilitate user input
    As a developer
    I use a lib

    Scenario: accepts raw input
        When input is passed to main entrypoint
        Then it should accept it

    Scenario: modify expected input based on passed input
        Given it is configured to accept a limited subset of data based on input
        When input is passed to main entrypoint
        Then it should not accept this input

