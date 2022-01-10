<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FileValidation {

	/**
	 * Validation data for the current form submission
	 *
	 * @var array
	 */
	protected $_fieldData		= array();

	/**
	 * Array of validation errors
	 *
	 * @var array
	 */
	protected $_errorArray		= array();

	// --------------------------------------------------------------------
	/**
	 * Set Rules
	 *
	 * This function takes an array of field names and validation
	 * rules as input, any custom error messages, validates the info,
	 * and stores it
	 *
	 * @param	mixed	$field
	 * @param	string	$label
	 * @param	mixed	$allowedTypes
	 * @param	array	$size
	 * @return	FileValidation
	 */
	public function setRules(string $field, string $label = '', array $allowedTypes, int $size, array $imageSize = array()){
		// Is the field name an array? If it is an array, we break it apart
		// into its components so that we can fetch the corresponding POST data later
		$is_array = (bool) preg_match_all('/\[(.*?)\]/', $field);
		sscanf($field, '%[^[][', $key);

		/*No value no rules, Nothing to do...*/
		if ($is_array && empty($_FILES[$key]['name'][0]))
		{
			return $this;
		}
		else if(empty($_FILES[$key]['name'])){
			return $this;
		}
		
		/*If the field label wasn't passed we use the field name*/
		$label = ($label === '') ? $field : $label;

		/*Build our master array*/
		$this->_fieldData[$key] = array(
			'field'		=> $field,
			'label'		=> $label,
			'allowedTypes' => $allowedTypes,
			'sizeAllowed' => $size,
			'imageSizeAllowed' => $imageSize,
			'is_array'	=> $is_array,
			'key'		=> $key,
			'error'		=> ''
		);

		return $this;
	}


	// --------------------------------------------------------------------
	/**
	 * Run the Validator
	 *
	 * This function does all the work.
	 *
	 * @return	bool
	 */
	public function run():bool{
		$files = array();

		/*Cycle through the rules for each field and match the corresponding $validation_data item*/
		foreach ($this->_fieldData as $field => &$row)
		{
			if ($row['is_array'] === TRUE)
			{
				foreach ($_FILES[$row['key']]['name'] as $key => $value) {
					$tempFile = array(
						'name' => $_FILES[$row['key']]['name'][$key],
						'type' => $_FILES[$row['key']]['type'][$key],
						'tmp_name' => $_FILES[$row['key']]['tmp_name'][$key],
						'error' => $_FILES[$row['key']]['error'][$key],
						'size' => $_FILES[$row['key']]['size'][$key],
					);
					$this->_execute($row['label'], $tempFile, $row['allowedTypes'], $row['sizeAllowed'], $row['key'], $row['imageSizeAllowed'], $key);
					$files[$row['key']][] = $tempFile;
				}
			}
			elseif (isset($_FILES[$field]))
			{
				$this->_execute($row['label'], $_FILES[$field], $row['allowedTypes'], $row['sizeAllowed'], $field, $row['imageSizeAllowed']);
				$files[$field] = &$_FILES[$field];
			}
		}

		$_FILES = $files;

		/*Did we end up with any errors?*/
		$total_errors = count($this->_errorArray);
		
		return ($total_errors === 0);
	}

	// --------------------------------------------------------------------

	/**
	 * Executes the Validation routines
	 *
	 * @param	array
	 * @param	array
	 * @param	int
	 * @param	field
	 * @return	mixed
	 */
	protected function _execute(string $label, array &$file, array $allowedTypes, int $size, string $field, array $imageSizeAllowed, string $fileIndex=null){
		$mimes = get_mimes();

		/*getting extension of file submitted*/
		$fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);

		/*manually blocking some extension*/
		$extension = array('php','exe','sh');
		if(in_array($fileExt, $extension)){
			/*creating error-array for field if it is a array field (eg: name[])*/
			if($this->_fieldData[$field]['is_array'] && !isset($this->_errorArray[$field])){
				$this->_errorArray[$field] = array();
			}

			if(isset($this->_errorArray[$field])){
				$this->_errorArray[$field][$fileIndex] = $label." Invalid File Type";
			}
			else{
				$this->_errorArray[$field] = $label." Invalid File Type";
			}
			return;
		}

		/*check extension*/
		if(! in_array($fileExt, $allowedTypes)){
			/*creating error-array for field if it is a array field (eg: name[])*/
			if($this->_fieldData[$field]['is_array'] && !isset($this->_errorArray[$field])){
				$this->_errorArray[$field] = array();
			}

			if(isset($this->_errorArray[$field])){
				$this->_errorArray[$field][$fileIndex] = $label." Invalid File Type";
			}
			else{
				$this->_errorArray[$field] = $label." Invalid File Type";
			}
			return;
		}
		$file['extension'] = $fileExt;

		/*checking mime-type*/
		if(! in_array($file['type'], $mimes[strtolower($fileExt)]))	{
			/*creating error-array for field if it is a array field (eg: name[])*/
			if($this->_fieldData[$field]['is_array'] && !isset($this->_errorArray[$field])){
				$this->_errorArray[$field] = array();
			}

			if(isset($this->_errorArray[$field])){
				$this->_errorArray[$field][$fileIndex] = $label." Invalid File";
			}
			else{
				$this->_errorArray[$field] = $label." Invalid File";
			}
			return;
		}

		/*checking size*/
		if(($file['size']/1024) > $size){
			/*creating error-array for field if it is a array field (eg: name[])*/
			if($this->_fieldData[$field]['is_array'] && !isset($this->_errorArray[$field])){
				$this->_errorArray[$field] = array();
			}

			$size = (1024 > $size)? (string) $size.' KB' : (string)($size / 1024).' MB';
			if(isset($this->_errorArray[$field])){
				$this->_errorArray[$field][$fileIndex] = $label.' File size must be less than '. $size;
			}else{
				$this->_errorArray[$field] =  $label.' File size must be less than '. $size;
			}
			return;
		}

		/*checking for error*/
		if($file['error'] > 0){
			/*creating error-array for field if it is a array field (eg: name[])*/
			if($this->_fieldData[$field]['is_array'] && !isset($this->_errorArray[$field])){
				$this->_errorArray[$field] = array();
			}

			if(isset($this->_errorArray[$field])){
				$this->_errorArray[$field][$fileIndex] = $label.' File Contain Errors';
			}
			else{
				$this->_errorArray[$field] = $label.' File Contain Errors';
			}
			return;
		}

		if(! $this->is_allowed_dimensions($file, $imageSizeAllowed)){
			/*creating error-array for field if it is a array field (eg: name[])*/
			if($this->_fieldData[$field]['is_array'] && !isset($this->_errorArray[$field])){
				$this->_errorArray[$field] = array();
			}
			
			if(isset($this->_errorArray[$field])){
				$this->_errorArray[$field][$fileIndex] = $label.' Invalid Image Size';
			}
			else{
				$this->_errorArray[$field] = $label.' Invalid Image Size';
			}
			return;
		}	
	}

	// --------------------------------------------------------------------

	/**
	 * Verify that the image is within the allowed width/height
	 *
	 * @return	bool
	 */
	public function is_allowed_dimensions($file, array $imageSizeAllowed){
		if ( ! $this->is_image($file))
		{
			return TRUE;
		}

		if (function_exists('getimagesize'))
		{
			$D = @getimagesize($file['tmp_name']);

			$max_width = isset($imageSizeAllowed['max_width']) ? $imageSizeAllowed['max_width'] : 0 ;
			$max_height = isset($imageSizeAllowed['max_height']) ? $imageSizeAllowed['max_height'] : 0 ;
			$min_width = isset($imageSizeAllowed['min_width']) ? $imageSizeAllowed['min_width'] : 0 ;
			$min_height = isset($imageSizeAllowed['min_height']) ? $imageSizeAllowed['min_height'] : 0 ;

			if ($max_width > 0 && $D[0] > $max_width)
			{
				return FALSE;
			}

			if ($max_height > 0 && $D[1] > $max_height)
			{
				return FALSE;
			}

			if ($min_width > 0 && $D[0] < $min_width)
			{
				return FALSE;
			}

			if ($min_height > 0 && $D[1] < $min_height)
			{
				return FALSE;
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate the image
	 *
	 * @return	bool
	 */
	public function is_image($file){
		// IE will sometimes return odd mime-types during upload, so here we just standardize all
		// jpegs or pngs to the same file type.
		$file_type = $file['type'];

		$png_mimes  = array('image/x-png');
		$jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');

		if (in_array($file['type'], $png_mimes))
		{
			$file_type = 'image/png';
		}
		elseif (in_array($file['type'], $jpeg_mimes))
		{
			$file_type = 'image/jpeg';
		}

		$img_mimes = array('image/gif',	'image/jpeg', 'image/png');

		return in_array($file_type, $img_mimes, TRUE);
	}

	// --------------------------------------------------------------------


	/**
	 * Get Array of Error Messages
	 *
	 * Returns the error messages as an array
	 *
	 * @return	array
	 */
	public function errorArray(){
		return $this->_errorArray;
	}


	// --------------------------------------------------------------------
	/**
	 * Get Array of Error Messages
	 *
	 * Returns the error messages as an array
	 *
	 * @return	array
	 */
	public function uploadFile(array $file, string $path, string $filename){
		/*checking directory exist or not*/
		if(! is_dir($path)){
			/*Creating directory*/
			mkdir($path);
		}

		$destination = $path.'/'.$filename.'.'.$file['extension'];
		if(move_uploaded_file($file['tmp_name'], $destination)){
			return TRUE;
		}
	}

}

/* End of file FileValidation.php */
/* Location: ./application/libraries/FileValidation.php */