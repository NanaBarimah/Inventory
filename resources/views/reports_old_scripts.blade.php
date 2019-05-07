<script>
if ($('#div-year').css('display') == 'none') {
                if ($('#report-type').val() == null || $('#report-details').val() == null) {
                    $('.text-danger').css('display', 'block');
                    return false;
                } else {
                    $('.text-danger').css('display', 'none');
                    /*if($('#report-details').val() == 'cummulative'){
                        $('#generate').html('Loading...');
                        $.ajax({
                            url : '/api/equipment/report/cummulative',
                            method: 'post',
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                console.log(data);
                                options = {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'pie'
                                    },
                                    title: {
                                        text: 'Inventory Report'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b style="text-transform: uppercase">{point.name}</b>: {point.percentage:.1f} %',
                                                style: {
                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                        name: 'Inventory',
                                        colorByPoint: true,
                                        data: data.response
                                    }]
                                };
                                loadGraph(options);
                            },
                            error: function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                                console.log(desc);
                            }
                        });
                    }else{
                        $('#generate').html('Loading...');
                        $.ajax({
                            url : '/api/equipment/report/categorized',
                            method: 'post',
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                console.log(data);
                                
                                //declaring various arrays to sort data for graph
                                categories = [];
                                actives = [];
                                inactives = [];
                                
                                //pushing the category names into one array
                                data.response.forEach(function(item, index){
                                    categories.push(item['category']);
                                })
            
                                //filtering category array to remove duplicates
                                categories = unique(categories);

                                //sorting active and inactive equipment into different arrays
                                actives = sortActive(data.response, categories);
                                inactives = sortInactive(data.response, categories);

                                //defining chart options
                                options = {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'column'
                                    },
                                    title: {
                                        text: 'Categorized Inventory Report'
                                    },
                                    xAxis: {
                                        categories: categories,
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Units'
                                        }
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b style="text-transform: uppercase">{point.name}</b>: {point.percentage:.1f} %',
                                                style: {
                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                }
                                            }
                                        }
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0
                                        }
                                    },
                                    series : [{
                                        name: 'Active',
                                        data: actives
                                    }, {
                                        name: 'Inactive',
                                        data: inactives
                                    }]
                                };
                                loadGraph(options);
                            },
                            error: function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                                console.log(desc);
                            }
                        });
                    }*/
                }
            } else {
                if ($('#report-type').val() == null || $('#report-details').val() == null || $('#report-year').val() == null) {
                    $('.text-danger').css('display', 'block');
                    return false;
                } else {
                    $('.text-danger').css('display', 'none');
                    $('#generate').html('Loading...');
                    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    if($('#report-details').val() == 'cummulative'){
                        request = $.ajax({
                            url : '/api/maintenances/report/cummulative',
                            method : 'post',
                            data : 'year='+$('#report-year').val(),
                            success: function(data, status){
                                var formatted_counts = [];
                                $('#generate').html('Generate Graph');
                                months.forEach(function(item, index){
                                    var month = item;
                                    var month_index = index;

                                    var isFound = false;
                                    data.response.forEach(function(item, index){
                                        if(item.month == month_index + 1){
                                            isFound = true;
                                            formatted_counts.push(item.maintenances);
                                        }
                                    });

                                    if(!isFound){
                                        formatted_counts.push(0);
                                    }
                                });
                                
                                var options = {
                                        title: {
                                            text: 'Cummulative Maintenance Report'
                                        },

                                        subtitle: {
                                            text: 'Year '+$('#report-year').val()
                                        },

                                        yAxis: {
                                            title: {
                                                text: 'Maintenance Frequency'
                                            }
                                        },
                                        legend: {
                                            layout: 'vertical',
                                            align: 'right',
                                            verticalAlign: 'middle'
                                        },

                                        xAxis: {
                                        categories: months,
                                        crosshair: true
                                        },

                                        series: [{
                                                name: $('#report-year').val(),
                                                data: formatted_counts
                                            }
                                        ],

                                        responsive: {
                                            rules: [{
                                                condition: {
                                                    maxWidth: 500
                                                },
                                                chartOptions: {
                                                    legend: {
                                                        layout: 'horizontal',
                                                        align: 'center',
                                                        verticalAlign: 'bottom'
                                                    }
                                                }
                                            }]
                                        }
                                }
                                loadGraph(options);
                            },
                            error : function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                            }
                        });
                    }else{
                        request = $.ajax({
                            url : '/api/maintenances/report/categorized',
                            method : 'post',
                            data : 'year='+$('#report-year').val(),
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                options = {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'pie'
                                    },
                                    title: {
                                        text: 'Categorized Maintenance Report for '+$('#report-year').val()
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.y}</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.percentage:.1f} %',
                                                style: {
                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                }
                                            },
                                            showInLegend: true
                                        }
                                    },
                                    series: [{
                                        name: 'Maintenances',
                                        colorByPoint: true,
                                        data: data.response
                                    }],
                                    events: {
                                        load: function(event) {
                                            var total = 0; // get total of data
                                            for (var i = 0, len = this.series[0].y.length; i < len; i++) {
                                                total += this.series[0].y[i];
                                            }
                                            var text = this.renderer.text(
                                                'Total: ' + total,
                                                this.plotLeft,
                                                this.plotTop - 20
                                            ).attr({
                                                zIndex: 5
                                            }).add() // write it to the upper left hand corner
                                        }
                                    }
                                };
                                loadGraph(options);
                            },
                            error : function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                            }
                        });
                    }
                }
            }
</script>