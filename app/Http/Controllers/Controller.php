<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\EntityTable\EntityTableHelper;
use App\Helpers\EntityTable\EntityColumnHelper;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $Favicon = [
        'Pokemon'=> 'Pokemon.png',
        'MTG'=> 'MTG.png',
    ];

    protected function MergeData($Name,$Images,$Attributes,$Color,$Sets) {
        $Data = (object) [
            'Name'=> $Name,
            'Images' => $Images,
            'Attributes' => $Attributes,
            'Color' => $Color,
            'Sets' => $Sets
        ];

        return $Data;
    }

    protected function mergeTableOptions($Table, array $opts): array {
        $ETH = new EntityTableHelper($Table);
        $ECH = new EntityColumnHelper($Table);
        //dd($ETH->getHeaders(),$ETH->getFilters());
        return array_merge([
            'TableHeaders' => $ETH->getHeaders(),
            'TableFilters' => $ETH->getFilters(),
            'TableColumns' => substr(json_encode($ECH->getColumns()), 1, -1),
            'TableURL' => $ETH->getDataURL(),
            'custonCSS' => $ETH->getCustomCSS(),
            'Favicon' => $this->Favicon[$Table],
        ], $opts);
    }

    protected function mergeDetailsOptions($Table, array $opts): array {
        $ETH = new EntityTableHelper($Table);

        return array_merge([
            'custonCSS' => $ETH->getCustomCSS(),
            'Favicon' => $this->Favicon[$Table],
        ], $opts);
    }

    protected function SetAttributes($AttSetup, $Data): object {
        $TempAttr = [];

        foreach ($AttSetup as $Key => $Items) {
            foreach ($Items['Value'] as $IKey => $Prop) {
                $TempName = $Items['HeaderName'][$IKey];
                $TempLeg = (count($Items['Legend']) > 0) ? $Items['Legend'][$IKey] : '';

                $Temp = (object) [
                    'Value' => (isset($Data->$Prop)) ? $Data->$Prop : '',
                    'Display' => (!in_array($Prop, $Items['DisplayBlock'])) ? 'Inline' : '',
                    'Legend' => ($TempLeg != '') ? '('.$Data->$TempLeg.')' : '',
                    'HTML' => in_array($Prop, $Items['HTML']),
                    'Bool' => in_array($Prop, $Items['Bool'])
                ];

                $TempAttr[$Key][$TempName] = $Temp;
            }
        }

        return (object) $TempAttr;
    }


}
