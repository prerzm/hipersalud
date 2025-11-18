<?php if(count($app_data)>0) { ?>
    // consultations attendance
    const chAtt = document.getElementById('consultations-chart');
    new Chart(chAtt, {
        type: 'pie',
        data: {
            labels: [<?=$app_data['labels'];?>],
            datasets: [
                {
                    data: [<?=$app_data['data'];?>],
                    backgroundColor: ['#3a87ad', '#468847', '#b94a48'],
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                    position: 'left',
                },
                title: {
                    display: false,
                    text: '<?=LABEL_CONSULTATIONS_ATTENDANCE;?>'
                }
            }
        },
    });
<?php } ?>

<?php if(count($data)>0) { ?>
    // weight chart
	const chWei = document.getElementById('weight-chart');
	new Chart(chWei, {
		type: 'line',
		data: {
			labels: [<?=$data['labels'];?>],
			datasets: [
				{
					label: '<?=LABEL_PARAMS_WEIGHT;?>',
					data: [<?=$data['weight'];?>],
					borderColor: '#3a87ad',
					backgroundColor: '#d9edf7'
				}
			]
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: '<?=LABEL_PARAMS_WEIGHT;?>'
				}
			}
		},
	});

    // bmi chart
	const chBMI = document.getElementById('bmi-chart');
	new Chart(chBMI, {
		type: 'line',
		data: {
			labels: [<?=$data['labels'];?>],
			datasets: [
				{
					label: '<?=LABEL_PARAMS_BMI;?>',
					data: [<?=$data['bmi'];?>],
					borderColor: '#c09853',
					backgroundColor: '#fcf8e3'
				}
			]
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: '<?=LABEL_PARAMS_BMI;?>'
				}
			}
		},
	});

	// heart rate chart
	const chHR = document.getElementById('hr-chart');
	new Chart(chHR, {
		type: 'line',
		data: {
			labels: [<?=$data['labels'];?>],
			datasets: [
				{
					label: '<?=LABEL_PARAMS_HEART_RATE;?>',
					data: [<?=$data['fc'];?>],
					borderColor: '#468847',
					backgroundColor: '#dff0d8'
				}
			]
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: '<?=LABEL_PARAMS_HEART_RATE;?>'
				}
			}
		},
	});

	// blood pressure chart
	const chBP = document.getElementById('bp-chart');
	new Chart(chBP, {
		type: 'line',
		data: {
			labels: [<?=$data['labels'];?>],
			datasets: [
				{
					label: '<?=LABEL_PARAMS_SYSTOLIC;?>',
					data: [<?=$data['presis'];?>],
					borderColor: '#3a87ad',
					backgroundColor: '#d9edf7'
				},
				{
					label: '<?=LABEL_PARAMS_DIASTOLIC;?>',
					data: [<?=$data['predia'];?>],
					borderColor: '#c09853',
					backgroundColor: '#fcf8e3'
				}
			]
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: '<?=LABEL_PARAMS_BLOOD_PRESSURE;?>'
				}
			}
		},
	});

	// glucose chart
	const chGlu = document.getElementById('glu-chart');
	new Chart(chGlu, {
		type: 'line',
		data: {
			labels: [<?=$data['labels'];?>],
			datasets: [
				{
					label: '<?=LABEL_PARAMS_GLUCOSE;?>',
					data: [<?=$data['glu'];?>],
					borderColor: '#b94a48',
					backgroundColor: '#f2dede'
				}
			]
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: '<?=LABEL_PARAMS_GLUCOSE;?>'
				}
			}
		},
	});

<?php } ?>