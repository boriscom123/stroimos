$(function(){
    if ($('.doc-kpi-charts').length > 0) {
        $.get('https://stroi.mos.ru/api/qlick/dgp/kpi-month', function(api_data) {
            api_data = api_data[0];

            var chart1_config = {
                type: 'doughnut',
                data: {
                    datasets: [{                    
                        data: [
                            api_data.gpzu_lm || 0,
                            api_data.rs_lm || 0,
                            api_data.rv_lm || 0,
                        ],
                        backgroundColor: [
                            '#195191',
                            '#2983e8',                        
                            '#76a9e3'
                        ], 
                    }, {
                        data: [
                            api_data.gpzu_avg_time_lm || 0,
                            api_data.rs_avg_time_lm || 0,
                            api_data.rv_avg_time_lm || 0,
                        ],
                        backgroundColor: [
                            '#222222',
                            '#5c5b5b',
                            '#969595'
                        ]
                    }],
                    labels: [
                        'Градостроительный план земельного участка',
                        'Разрешение на строительство',
                        'Разрешение на ввод в эксплуатацию',
                    ],
                },                       
                options: {
                    responsive: true,
                    circumference: Math.PI,
				    rotation: -Math.PI,
                    legend: {
                        display: false
                    },              
                    plugins: {                    
                        labels: [
                            {
                                render: 'value',
                                fontSize: 14,
                                fontColor: '#fff'                            
                            }
                        ]
                    },
                    tooltips: {
                        footerFontStyle: 'normal',
                        displayColors: false,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.labels[tooltipItem.index];                                
                                return label;
                            },
                            footer: function(tooltipItem, data) {
                                var footer;
                                if (tooltipItem[0].datasetIndex == 0) {
                                    footer = '(количество документов)';
                                } else {
                                    footer = '(среднее количество дней на документ)';
                                }  
                                return footer;                              
                            }
                        }
                    }
                }            
            };

            var chart1_element = document.getElementById('doc-kpi-chart1').getContext('2d');
            var chart1 = new Chart(chart1_element, chart1_config);

            var chart2_config = {
                type: 'doughnut',
                data: {
                    datasets: [{                    
                        data: [
                            api_data.gpzu || 0,
                            api_data.rs_month || 0,
                            api_data.rv_month || 0,
                        ],
                        backgroundColor: [
                            '#195191',
                            '#2983e8',                        
                            '#76a9e3'
                        ], 
                    }, {
                        data: [
                            api_data.gpzu_avg_time || 0,
                            api_data.rs_avg_time_month || 0,
                            api_data.rv_avg_time_month || 0,
                        ],
                        backgroundColor: [
                            '#222222',
                            '#5c5b5b',
                            '#969595'
                        ]
                    }],
                    labels: [
                        'Градостроительный план земельного участка',
                        'Разрешение на строительство',
                        'Разрешение на ввод в эксплуатацию',
                    ],
                },                       
                options: {
                    responsive: true,
                    circumference: Math.PI,
				    rotation: -Math.PI,
                    legend: {
                        display: false
                    },              
                    plugins: {                    
                        labels: [
                            {
                                render: 'value',
                                fontSize: 14,
                                fontColor: '#fff'                            
                            }
                        ]
                    },
                    tooltips: {
                        footerFontStyle: 'normal',
                        displayColors: false,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.labels[tooltipItem.index];                                
                                return label;
                            },
                            footer: function(tooltipItem, data) {
                                var footer;
                                if (tooltipItem[0].datasetIndex == 0) {
                                    footer = '(количество документов)';
                                } else {
                                    footer = '(среднее количество дней на документ)';
                                }  
                                return footer;                              
                            }
                        }
                    }
                }            
            };

            var chart2_element = document.getElementById('doc-kpi-chart2').getContext('2d');
            var chart2 = new Chart(chart2_element, chart2_config);

            $('.doc-kpi-charts-title_lm span').text(api_data.lm.toLowerCase());
            $('.doc-kpi-charts-title_month span').text(api_data.month.toLowerCase());

            $('.doc-kpi-table-toptoptitle_lm span').text(api_data.lm);
            $('.doc-kpi-table-toptoptitle_month span').text(api_data.month.toLowerCase());

            $('.doc-kpi-table-data_gpzu_c_lm').text(api_data.gpzu_lm || '–');
            $('.doc-kpi-table-data_gpzu_a_lm').text(api_data.gpzu_avg_time_lm || '–');
            $('.doc-kpi-table-data_gpzu_c_m').text(api_data.gpzu || '–');
            $('.doc-kpi-table-data_gpzu_a_m').text(api_data.gpzu_avg_time || '–');

            $('.doc-kpi-table-data_rs_c_lm').text(api_data.rs_lm || '–');
            $('.doc-kpi-table-data_rs_a_lm').text(api_data.rs_avg_time_lm || '–');
            $('.doc-kpi-table-data_rs_c_m').text(api_data.rs_month || '–');
            $('.doc-kpi-table-data_rs_a_m').text(api_data.rs_avg_time_month || '–');

            $('.doc-kpi-table-data_rv_c_lm').text(api_data.rv_lm || '–');
            $('.doc-kpi-table-data_rv_a_lm').text(api_data.rv_avg_time_lm || '–');
            $('.doc-kpi-table-data_rv_c_m').text(api_data.rv_month || '–');
            $('.doc-kpi-table-data_rv_a_m').text(api_data.rv_avg_time_month || '–');

        });
    }    
});