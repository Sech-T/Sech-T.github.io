<?php
/**
 *
 * @ EvolutionScript FULL DECODED & NULLED
 *
 * @ Version  : 5.1
 * @ Author   : MTIMER
 * @ Release on : 2014-09-01
 * @ Website  : http://www.mtimer.net
 *
 **/

if (!defined("EvolutionScript")) {
	exit("Hacking attempt...");
}

$contrynum = $db->fetchOne("SELECT COUNT(*) AS NUM FROM country");
$statsquery = $db->query("SELECT * FROM statistics");

while ($list = $db->fetch_array($statsquery)) {
	$stats[$list['field']] = $list['value'];
}

$query = $db->query("SELECT name, total_deposit, total_withdraw FROM gateways ORDER BY name ASC");

while ($row = $db->fetch_array($query)) {
	$gatewaynames .= "'" . $row['name'] . "',";
	$gatewayincome .= $row['total_deposit'] . ",";
	$gatewayoutcome .= $row['total_withdraw'] . ",";
}

$gatewaynames = substr($gatewaynames, 0, strlen($gatewaynames) - 1);
$gatewayincome = substr($gatewayincome, 0, strlen($gatewayincome) - 1);
$gatewayoutcome = substr($gatewayoutcome, 0, strlen($gatewayoutcome) - 1);
$deposits = $db->fetchOne("SELECT SUM(amount) FROM deposit_history");
$deposits = ($deposits == "" ? "0.00" : $deposits);

if (!$pendingcashout) {
	$pendingcashout = "0.00";
}

$higher_country = $db->fetchOne("SELECT users FROM country ORDER BY users DESC LIMIT 1");
$higher_country = (empty($higher_country) ? $higher_country : 1000);
echo "
<!-- Maps  and chart loader -->
<script type=\"text/javascript\" src=\"./js/highmaps/highcharts.js\"></script>
<script type=\"text/javascript\" src=\"./js/highmaps/modules/map.js\"></script>
<script type=\"text/javascript\" src=\"./js/highmaps/modules/data.js\"></script>
<script type=\"text/javascript\" src=\"./js/highmaps/world.js\"></script>
<script type=\"text/javascript\">
$(function () {
    $.getJSON('./?view=js&type=map&callback=?', function (data) {
        // Initiate the chart
        $('#map_container').highcharts('Map', {
            title : {
                text : ''
            },
			chart : {
				backgroundColor	: '#eaf7fe'
			},
			credits : {
				enabled: false,
			},
            mapNavigation: {
                enabled: false,
            },
            colorAxis: {
                min: 1,
                max: ";
echo $higher_country;
echo ",
                type: 'logarithmic',
				minColor: '#dbfdcb',
				maxColor: '#1e5b10',
            },
			legend: {
				align: 'left',
				layout: 'vertical',
			},
            series : [{
                data : data,
                mapData: Highcharts.maps['custom/world'],
                joinBy: ['iso-a2', 'code'],
                name: 'Members',
                states: {
                    hover: {
                        color: '#fbd843'
                    }
                },
                tooltip: {
                    valueSuffix: ''
                }
            }]
        });
    });
});
		</script>
		<script type=\"text/javascript\">

			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'members_stats',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: null,
					},
					subtitle: {
						text: 'Total members: ";
echo $stats['members'];
echo "'
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +' members';
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: false
							},
							showInLegend: true
						}
					},
				    series: [{
						type: 'pie',
						name: 'Browser share',
						data: [
							{name:'Active',   y: ";
echo $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE status='Active' AND username!='BOT'");
echo ", sliced: true, selected: true},
							['Inactive',  ";
echo $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE status='Inactive' AND username!='BOT'");
echo "],
							['Suspended', ";
echo $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE status='Suspended' AND username!='BOT'");
echo "],
							['Unverified',    ";
echo $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE status='Un-verified' AND username!='BOT'");
echo "],
							['Bots',    ";
echo $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE username='BOT'");
echo "]
						]
					}],
				  credits: {
					 enabled: false
				  },
				});
			});

		</script>

		<script type=\"text/javascript\">

			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'financial_stats',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: null,
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: $'+ this.y +' USD';
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: false
							},
							showInLegend: true
						}
					},
				    series: [{
						type: 'pie',
						name: 'Browser share',
						data: [
							['Deposits',   ";
echo $deposits;
echo "],
							['Withdrawals',       ";
echo $stats['cashout'];
echo "],
							['Pending',       ";
echo $pendingcashout;
echo "],
						]
					}],
				  credits: {
					 enabled: false
				  },
				});
			});

		</script>


		<script type=\"text/javascript\">

var chart;
$(document).ready(function() {
   chart = new Highcharts.Chart({
      chart: {
         renderTo: 'gateway_stats',
         defaultSeriesType: 'bar'
      },
      title: {
         text: null,
      },

      xAxis: {

         categories: [";
echo $gatewaynames;
echo "],
         title: {
            text: null
         }
      },
      yAxis: {
         min: 0,
         title: {
            text: 'Income/Outcome',
            align: 'high'
         }
      },
      tooltip: {
		formatter: function() {
			return ''+
				this.x +': $'+ this.y;
		}
      },
      plotOptions: {
         bar: {
            dataLabels: {
               enabled: true
            }
         }
      },
      legend: {
         layout: 'vertical',
         align: 'right',
         verticalAlign: 'top',
         x: -100,
         y: 100,
         floating: true,
         borderWidth: 1,
         backgroundColor: '#FFFFFF',
         shadow: true
      },
      credits: {
         enabled: false
      },
           series: [{
			name: 'Deposits',
         data: [";
echo $gatewayincome;
echo "]
      },{
	  	name: 'Withdrawals',
		data: [";
echo $gatewayoutcome;
echo "]
	  }]
   });


});
		</script>


        <div class=\"dashbaord-img-1\">
            <div class=\"widget-title\">Member Statistics</div>
            <div class=\"widget-content\">
                <div id=\"members_stats\" style=\"height: 250px;\"></div>
            </div>
        </div>
        <div class=\"dashbaord-img-2\">
            <div class=\"widget-title\">Financial Statistics</div>
            <div class=\"widget-content\">
                <div id=\"financial_stats\" style=\"min-height: 250px;\"></div>
            </div>
        </div>
        <div class=\"clear\"></div>
        <div class=\"widget-title\">Income/Outcome Per Payment Processor</div>
        <div class=\"widget-content\">
            <div id=\"gateway_stats\" style=\"min-height: 300px;\"></div>
        </div>

        <div class=\"widget-title\">Country Statistics</div>
        <div id=\"map_container\"></div>
";
?>