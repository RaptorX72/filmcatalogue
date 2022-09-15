<?php
class UploadStatus {
	private $result;
	private $imagename;

	public function getResult() {
		return $this->result;
	}

	public function getImageName() {
		return $this->imagename;
	}

	function __construct($r, $i) {
		$this->result = $r;
		$this->imagename = $i;
	}
}

$uploaddir = "../resources/img/";

function generateName() {
	$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$randStringLen = 10;
	$randString = "";
	for ($i = 0; $i < $randStringLen; $i++)
		$randString .= $charset[mt_rand(0, strlen($charset) - 1)];
	return $randString;
}

function uploadImage($file) {
	global $uploaddir;
	$fileType = strtolower(pathinfo($file["name"] ,PATHINFO_EXTENSION));
	$imagename = generateName() . '.' . $fileType;
	$target_file = $uploaddir . $imagename;
	$res = null;
	try {
		move_uploaded_file($file["tmp_name"], $target_file);
		if(!file_exists($target_file)) $res = new UploadStatus(false, $imagename);
	} catch (Exception $e) {
		$res = new UploadStatus(false, $imagename);
	}
	if(is_null($res)) $res = new UploadStatus(true, $imagename);
	return $res;
}

function deleteImage($id, $table) {
	global $con;
	global $uploaddir;
	$resimg = mysqli_query($con, "SELECT image FROM " . $table . " WHERE id = " . $id);
	$rowimg = mysqli_fetch_assoc($resimg);
	if (!empty($rowimg['image'])) {
		$filename = $uploaddir . $rowimg['image'];
		if (file_exists($filename)) {
			try {
				unlink($filename);
			} catch (Exception $e) {
				return false;
			}
			return true;
		}
	} else return true;
}
?>