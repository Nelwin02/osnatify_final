/*
Author       : Dreamguys
Template Name: Doccure - Bootstrap Admin Template
Version      : 1.0
*/

(function($) {
    "use strict";
	
	// Variables declarations
	
	var $wrapper = $('.main-wrapper');
	var $pageWrapper = $('.page-wrapper');
	var $slimScrolls = $('.slimscroll');
	
	// Sidebar
	
	var Sidemenu = function() {
		this.$menuItem = $('#sidebar-menu a');
	};
	
	function init() {
		var $this = Sidemenu;
		$('#sidebar-menu a').on('click', function(e) {
			if($(this).parent().hasClass('submenu')) {
				e.preventDefault();
			}
			if(!$(this).hasClass('subdrop')) {
				$('ul', $(this).parents('ul:first')).slideUp(350);
				$('a', $(this).parents('ul:first')).removeClass('subdrop');
				$(this).next('ul').slideDown(350);
				$(this).addClass('subdrop');
			} else if($(this).hasClass('subdrop')) {
				$(this).removeClass('subdrop');
				$(this).next('ul').slideUp(350);
			}
		});
		$('#sidebar-menu ul li.submenu a.active').parents('li:last').children('a:first').addClass('active').trigger('click');
	}
	
	// Sidebar Initiate
	init();
	
	// Mobile menu sidebar overlay
	
	$('body').append('<div class="sidebar-overlay"></div>');
	$(document).on('click', '#mobile_btn', function() {
		$wrapper.toggleClass('slide-nav');
		$('.sidebar-overlay').toggleClass('opened');
		$('html').addClass('menu-opened');
		return false;
	});
	
	// Sidebar overlay
	
	$(".sidebar-overlay").on("click", function () {
		$wrapper.removeClass('slide-nav');
		$(".sidebar-overlay").removeClass("opened");
		$('html').removeClass('menu-opened');
	});
	
	// Page Content Height
	
	if($('.page-wrapper').length > 0 ){
		var height = $(window).height();	
		$(".page-wrapper").css("min-height", height);
	}
	
	// Page Content Height Resize
	
	$(window).resize(function(){
		if($('.page-wrapper').length > 0 ){
			var height = $(window).height();
			$(".page-wrapper").css("min-height", height);
		}
	});
	
	// Select 2
	
    if ($('.select').length > 0) {
        $('.select').select2({
            minimumResultsForSearch: -1,
            width: '100%'
        });
    }
	
	// Datetimepicker
	
	if($('.datetimepicker').length > 0 ){
		$('.datetimepicker').datetimepicker({
			format: 'DD/MM/YYYY',
			icons: {
				up: "fa fa-angle-up",
				down: "fa fa-angle-down",
				next: 'fa fa-angle-right',
				previous: 'fa fa-angle-left'
			}
		});
		$('.datetimepicker').on('dp.show',function() {
			$(this).closest('.table-responsive').removeClass('table-responsive').addClass('temp');
		}).on('dp.hide',function() {
			$(this).closest('.temp').addClass('table-responsive').removeClass('temp')
		});
	}

	// Tooltip
	
	if($('[data-toggle="tooltip"]').length > 0 ){
		$('[data-toggle="tooltip"]').tooltip();
	}
	
    // Datatable

    if ($('.datatable').length > 0) {
        $('.datatable').DataTable({
            "bFilter": false,
        });
    }
	
	// Email Inbox

	if($('.clickable-row').length > 0 ){
		$(document).on('click', '.clickable-row', function() {
			window.location = $(this).data("href");
		});
	}

	// Check all email
	
	$(document).on('click', '#check_all', function() {
		$('.checkmail').click();
		return false;
	});
	if($('.checkmail').length > 0) {
		$('.checkmail').each(function() {
			$(this).on('click', function() {
				if($(this).closest('tr').hasClass('checked')) {
					$(this).closest('tr').removeClass('checked');
				} else {
					$(this).closest('tr').addClass('checked');
				}
			});
		});
	}
	
	// Mail important
	
	$(document).on('click', '.mail-important', function() {
		$(this).find('i.fa').toggleClass('fa-star').toggleClass('fa-star-o');
	});
	
	// Summernote
	
	if($('.summernote').length > 0) {
		$('.summernote').summernote({
			height: 200,                 // set editor height
			minHeight: null,             // set minimum height of editor
			maxHeight: null,             // set maximum height of editor
			focus: false                 // set focus to editable area after initializing summernote
		});
	}
	
    // Product thumb images

    if ($('.proimage-thumb li a').length > 0) {
        var full_image = $(this).attr("href");
        $(".proimage-thumb li a").click(function() {
            full_image = $(this).attr("href");
            $(".pro-image img").attr("src", full_image);
            $(".pro-image img").parent().attr("href", full_image);
            return false;
        });
    }

    // Lightgallery

    if ($('#pro_popup').length > 0) {
        $('#pro_popup').lightGallery({
            thumbnail: true,
            selector: 'a'
        });
    }
	
	// Sidebar Slimscroll

	if($slimScrolls.length > 0) {
		$slimScrolls.slimScroll({
			height: 'auto',
			width: '100%',
			position: 'right',
			size: '7px',
			color: '#ccc',
			allowPageScroll: false,
			wheelStep: 10,
			touchScrollStep: 100
		});
		var wHeight = $(window).height() - 60;
		$slimScrolls.height(wHeight);
		$('.sidebar .slimScrollDiv').height(wHeight);
		$(window).resize(function() {
			var rHeight = $(window).height() - 60;
			$slimScrolls.height(rHeight);
			$('.sidebar .slimScrollDiv').height(rHeight);
		});
	}
	
	// Small Sidebar

	$(document).on('click', '#toggle_btn', function() {
		if($('body').hasClass('mini-sidebar')) {
			$('body').removeClass('mini-sidebar');
			$('.subdrop + ul').slideDown();
		} else {
			$('body').addClass('mini-sidebar');
			$('.subdrop + ul').slideUp();
		}
		setTimeout(function(){ 
			mA.redraw();
			mL.redraw();
		}, 300);
		return false;
	});
	$(document).on('mouseover', function(e) {
		e.stopPropagation();
		if($('body').hasClass('mini-sidebar') && $('#toggle_btn').is(':visible')) {
			var targ = $(e.target).closest('.sidebar').length;
			if(targ) {
				$('body').addClass('expand-menu');
				$('.subdrop + ul').slideDown();
			} else {
				$('body').removeClass('expand-menu');
				$('.subdrop + ul').slideUp();
			}
			return false;
		}
	});

	// animation ng data progress

	document.addEventListener('DOMContentLoaded', function() {
		function updateProgressBar(elementId, totalData) {
			const progressBar = document.getElementById(elementId);
			const countedData = parseInt(progressBar.getAttribute('data-count'));
			const percentage = (countedData / totalData) * 100;
	
			
			progressBar.style.width = '0%';
	
			
			setTimeout(() => {
				progressBar.style.width = percentage + '%';
			}, 5); 
		}
	
		const totalData = 100; 
	
		updateProgressBar('doctorProgressBar', totalData);
		updateProgressBar('patientProgressBar', totalData);
		updateProgressBar('clerkProgressBar', totalData);
	});

	document.addEventListener('DOMContentLoaded', function() {
		const viewMoreButtons = document.querySelectorAll('.viewMoreBtn');
	
		viewMoreButtons.forEach(button => {
			button.addEventListener('click', function() {
				const patientId = this.dataset.id; // Get ID from data attribute
	
				// AJAX request to fetch patient details
				fetch(`db.php?id=${patientId}`)
					.then(response => {
						if (!response.ok) {
							throw new Error('Network response was not ok');
						}
						return response.json();
					})
					.then(data => {
						// Check if data contains patient details
						if (data) {
							// Update modal content using details from JSON response
							const modalBody = document.getElementById('patientDetails');
							modalBody.innerHTML = `
								<table class="table table-striped">
									<tr>
										<th>Weight</th>
										<td>${data.weight} kg</td>
									</tr>
									<tr>
										<th>Height</th>
										<td>${data.height} cm</td>
									</tr>
									<tr>
										<th>Blood Pressure</th>
										<td>${data.bloodpressure}</td>
									</tr>
									<tr>
										<th>Heart Rate</th>
										<td>${data.heartrate} bpm</td>
									</tr>
									<tr>
										<th>Symptoms</th>
										<td>${data.symptoms}</td>
									</tr>
									<tr>
										<th>Predicted Disease</th>
										<td>${data.predicted_disease}</td>
									</tr>
									<tr>
										<th>Disease</th>
										<td>${data.disease}</td>
									</tr>
									<tr>
										<th>Prescription</th>
										<td>${data.prescription}</td>
									</tr>
									<tr>
										<th>Medication</th>
										<td>${data.medication}</td>
									</tr>
								</table>
							`;
	
							// Show the modal
							const patientModal = new bootstrap.Modal(document.getElementById('patientModal'), {
								keyboard: false
							});
							patientModal.show();
	
							// Optional: You can add an event listener to the modal's hide event
							// to perform any cleanup if needed
							patientModal._element.addEventListener('hidden.bs.modal', function() {
								// Optionally clear the modal content when closed
								modalBody.innerHTML = ''; // Clear previous data
							});
						} else {
							alert('No data found for this patient.');
						}
					})
					.catch(error => {
						console.error('Error retrieving patient details:', error);
						alert('Error retrieving patient details. Please try again.');
					});
			});
		});
	});
	

	


	
	
	


	
	

	
})(jQuery);