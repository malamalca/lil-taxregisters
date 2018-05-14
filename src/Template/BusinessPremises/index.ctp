<?php
    $premiseIndex = [
        'title_for_layout' => __d('lil_tax_registers', 'Business Premises List'),
        'menu' => [
            'add' => [
                'title' => __d('lil_tax_registers', 'Add'),
                'visible' => $this->Lil->userLevel('admin'),
                'url' => [
                    'action' => 'add',
                ],
                /*'params' => [
                    'onclick' => sprintf(
                        'popup("%s", $(this).prop("href"), \'auto\'); return false;',
                        __d('lil_tax_registers', 'Add Premise')
                    )
                ]*/
            ]
        ],
        'table' => [
            'parameters' => [
                'width' => '100%', 'cellspacing' => 0, 'cellpadding' => 0,
                'id' => 'BusinessPremiseIndex', 'class' => 'index'
            ],
            'head' => ['rows' => [['columns' => [
                'no' => __d('lil_tax_registers', 'Type'),
                'title' => __d('lil_tax_registers', 'Title'),
            ]]]],
        ]
    ];

    foreach ($businessPremises as $bp) {
        $premiseIndex['table']['body']['rows'][]['columns'] = [
            'no' => $bp->no,
            'title' => [
                'html' => $this->Html->link(
                    $bp->title,
                    [
                        'action' => 'view',
                        $bp->id
                    ]
                )
            ],
            
        ];
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    // call plugin handlers and output data
    echo $this->Lil->index($premiseIndex, 'LilTaxRegisters.BusinessPremises.index');