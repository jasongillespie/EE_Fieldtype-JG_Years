<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jg_years_ft extends EE_Fieldtype {

	var $info = array(
		'name'		=> 'JG Years',
		'version'	=> '2.0'
	);

	// --------------------------------------------------------------------

	function display_field ($year){
		
		return form_dropdown(
			$this->field_name,
			$this->_get_years(),
			$year, 
			"id='$this->field_id'"
		);
	}
	
	function display_settings ($data) {
		
		// Javascript output
		$js = "
			<script>
				
				jg_years = {
					toggleStart: function () {
						if ($('#year_start_current').is(':checked')) {
							$('#year_start').parents('tr').hide();
						}
						else {
							$('#year_start').parents('tr').show();
						}
					},
					
					toggleEnd: function () {
						if ($('#use_offset').is(':checked')) {
							$('#year_end_offset').parents('tr').show();
							$('#year_end').parents('tr').hide();
						}
						else {
							$('#year_end').parents('tr').show();
							$('#year_end_offset').parents('tr').hide();
							
						}
					}
				}
				
				jg_years.toggleStart();
				jg_years.toggleEnd();
				
				$('#year_start_current').change(function () {
					jg_years.toggleStart()
				});
				
				$('#use_offset').change(function () {
					jg_years.toggleEnd()
				});
				
			</script>
		";
		
		$year_start_current	= isset($data['year_start_current']) ? $data['year_start_current'] : $this->settings['year_start_current'];
		$year_start			= isset($data['year_start']) ? $data['year_start'] : $this->settings['year_start'];
		$use_offset			= isset($data['use_offset']) ? $data['use_offset'] : $this->settings['use_offset'];
		$year_end_offset	= isset($data['year_end_offset']) ? $data['year_end_offset'] : $this->settings['year_end_offset'];
		$year_end			= isset($data['year_end']) ? $data['year_end'] : $this->settings['year_end'];

		$this->EE->table->add_row(
			form_label('Start from current year?','year_start_current'),
			form_checkbox('year_start_current', 'true', $year_start_current, 'id="year_start_current"')
		);
		
		$this->EE->table->add_row(
			form_label('Start Year','year_start'),
			form_input('year_start', $year_start, 'id="year_start"')
		);
		
		$this->EE->table->add_row(
			form_label('Use Offset?','use_offset'),
			form_checkbox('use_offset', 'true', $use_offset, 'id="use_offset"')
		);

		$this->EE->table->add_row(
			form_label('End Year Offset','year_end_offset'),
			form_input('year_end_offset', $year_end_offset, 'id="year_end_offset"')
		);

		$this->EE->table->add_row(
			form_label('End Year','year_end'),
			form_input('year_end', $year_end, 'id="year_end"').$js
		);
		
	}
	
	function save_settings($data) {
		return array(
			'year_start_current'	=> $this->EE->input->post('year_start_current'),
			'year_start'			=> $this->EE->input->post('year_start'),
			'use_offset'			=> $this->EE->input->post('use_offset'),
			'year_end_offset'		=> $this->EE->input->post('year_end_offset'),
			'year_end'				=> $this->EE->input->post('year_end')
		);
	}
	
	function install() {
		
		// Set defaults
		$year_start_current = true;
		$use_offset = true;
		$year_end_offset = 50;
		$year_start = (int) date('Y');
		$year_end = $year_start - $year_end_offset;

		return array(
			'year_start_current' => $year_start_current,
			'year_end_offset' => $year_end_offset,
			'use_offset' => $use_offset,
			'year_start' => $year_start,
			'year_end' => $year_end
	    );
	}
	
	function _get_years () {
		
		if ($this->settings['year_start_current']) {
			$year_start = (int) date('Y');
		}
		else {
			$year_start = $this->settings['year_start'];
		}
		
		if ($this->settings['use_offset']) {
			$year_end = $year_start - $this->settings['year_end_offset'];
		}
		else {
			$year_end = $this->settings['year_end'];
		}
		
		for ($y = $year_start; $y >= $year_end; $y--) {
			$years[$y] = $y;
		}
		
		return $years;
	}
}

/* End of file ft.jg_years.php */
/* Location: ./system/expressionengine/third_party/jg_years/ft.jg_years
*.php */