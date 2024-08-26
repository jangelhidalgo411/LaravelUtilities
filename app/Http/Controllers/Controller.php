<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $Headers = [
        'tickets'=> [
            'Id',
            'Name',
            'External Id',
            'Created At'
        ],
        'organizations'=> [
            'Id',
            'Priority',
            'Status',
            'Subject',
            'Description',
            'Created At',
            'Last Updated'
        ],
        'pokemon'=> [
            'Number',
            'Name',
            'Normal Sprite',
            'Shiny Sprite',
            ''
        ]
    ];

    protected $Columns = [
        [
            'Id',
            'Name',
            'External Id',
            'Created At'
        ],
        'organizations'=> [
            'Id',
            'Priority',
            'Status',
            'Subject',
            'Description',
            'Created At',
            'Last Updated'
        ],
        'pokemon'=> [
            [
                'data'           => 'number',
                'orderable'      => true,
                'width'          => '5%',
                'defaultContent' => ''
            ],
            [
                'data'           => 'name',
                'orderable'      => true,
                'defaultContent' => ''
            ],
            [
                'data'           => 'normal',
                'orderable'      => false,
                'width'          => '15%',
                'defaultContent' => ''
            ],
            [
                'data'           => 'shiny',
                'orderable'      => false,
                'width'          => '15%',
                'defaultContent' => ''
            ],
            [
                'data'           => 'action',
                'orderable'      => false,
                'width'          => '10%',
                'defaultContent' => ''
            ],
        ]
    ];

    protected $GetURLs = [
        'pokemon'=> '/Getpokemons?ExcludeFirst=0&AmountPerPage=100'
    ];

    protected $custonCSS = [
        'pokemon'=> 'pokemon'
    ];


    protected function MergeOptions($data, array $opts): array {
        return array_merge([
            'TableHeaders' => $this->Headers[$data],
            'TableColumns' => substr(json_encode($this->Columns[$data]), 1, -1),
            'TableURL' => $this->GetURLs[$data],
            'custonCSS' => $this->custonCSS[$data],
        ], $opts);
    }


}
