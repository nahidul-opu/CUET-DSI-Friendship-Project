<?php


class BooksController
{
    private $db = null;
    private $requestMethod;
    private $isbn;
    function __construct($dbConnector, $method, $isbn)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        if ($isbn) $this->isbn = $isbn;
    }

    function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                print_r("inserting data");
                break;
            case 'GET':
                if ($this->isbn) print_r("Retriving data of " . $this->isbn);
                else print_r("Retriving all data");
                break;
            case 'PUT':
                if ($this->isbn) print_r("Updating " . $this->isbn);
                else $this->raiseException();
                break;
            case 'DELETE':
                if ($this->isbn) print_r("Deleting " . $this->isbn);
                else $this->raiseException();
                break;
            default:
                print_r("Unknown Request Method");
                break;
        }
    }

    function raiseException()
    {
        print_r("Invalid API or Request Method");
    }
}