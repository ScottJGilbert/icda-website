<?php

class File
{

  private function getSeason($archive_id)
  {
    //Will need to adjust how $archive_id matches to a season depending on what the earliest season entered into the database is
    return (2018 + $archive_id) . "-" . (2019 + $archive_id);
  }

  public function uploadLegislation($tournament_id)
  {
    $tournament_name = $tournament_id === 6 ? 'state' : (string) $tournament_id;

    $targetFile = PROJECT_ROOT . "/tournaments/icda-$tournament_name/legislation.pdf";
    $uploadedFile = $_FILES["legislation"]["name"];

    $uploadedType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));
    $mimeType = str_replace("application/", "", mime_content_type($_FILES["legislation"]["tmp_name"]));

    if ($uploadedType !== 'pdf' || $mimeType !== 'pdf') {
      Response::error('Invalid file type. Only PDF files are allowed.', 400);
      exit;
    }

    if (!$this->isLegislationMagicNumberValid()) {
      Response::error('Invalid file magic number. The file may be corrupted or not a valid PDF.', 400);
      exit;
    }

    if ($_FILES["legislation"]["size"] > 8000000) {
      Response::error('File size exceeds the limit of 8MB.', 400);
      exit;
    }

    if (!move_uploaded_file($_FILES["legislation"]["tmp_name"], $targetFile)) {
      Response::error('Failed to upload legislation file.', 500);
      exit;
    }
  }

  public function deleteLegislation($tournament_id)
  {
    $tournament_name = $tournament_id === 6 ? 'state' : (string) $tournament_id;

    $targetFile = PROJECT_ROOT . "/tournaments/icda-$tournament_name/legislation.pdf";
    if (file_exists($targetFile)) {
      if (!unlink($targetFile)) {
        Response::error('Failed to delete legislation file.', 500);
        exit;
      }
    } else {
      Response::error('Legislation file does not exist.', 404);
      exit;
    }
  }

  public function uploadArchiveLegislation($archive_id, $tournament_id)
  {
    $season = $this->getSeason($archive_id);

    $tournament_name = $tournament_id === 6 ? 'state' : (string) $tournament_id;

    $targetFile = PROJECT_ROOT . "/archive/$season/icda-$tournament_name-legislation.pdf";
    $uploadedFile = $_FILES["legislation"]["name"];

    $uploadedType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));
    $mimeType = str_replace("application/", "", mime_content_type($_FILES["legislation"]["tmp_name"]));

    if ($uploadedType !== 'pdf' || $mimeType !== 'pdf') {
      Response::error('Invalid file type. Only PDF files are allowed.', 400);
      exit;
    }

    if (!$this->isLegislationMagicNumberValid()) {
      Response::error('Invalid file magic number. The file may be corrupted or not a valid PDF.', 400);
      exit;
    }

    if ($_FILES["legislation"]["size"] > 8000000) {
      Response::error('File size exceeds the limit of 8MB.', 400);
      exit;
    }

    if (move_uploaded_file($_FILES["legislation"]["tmp_name"], $targetFile)) {
      Response::success('Legislation file uploaded successfully.', 200);
      exit;
    } else {
      Response::error('Failed to upload legislation file.', 500);
      exit;
    }
  }

  public function deleteArchiveLegislation($archive_id, $tournament_id)
  {
    $season = $this->getSeason($archive_id);

    $tournament_name = $tournament_id === 6 ? 'state' : (string) $tournament_id;

    $targetFile = PROJECT_ROOT . "/archive/$season/icda-$tournament_name-legislation.pdf";

    if (file_exists($targetFile)) {
      if (!unlink($targetFile)) {
        Response::error('Failed to delete legislation file.', 500);
        exit;
      }
    } else {
      Response::error('Legislation file does not exist.', 404);
      exit;
    }
  }

  public function uploadResults($tournament_id)
  {
    $tournament_name = $tournament_id === 6 ? 'state' : (string) $tournament_id;

    $targetFile = PROJECT_ROOT . "/tournaments/icda-$tournament_name/results.pdf";
    $uploadedFile = $_FILES["results"]["name"];

    $uploadedType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));
    $mimeType = str_replace("application/", "", mime_content_type($_FILES["results"]["tmp_name"]));

    if ($uploadedType !== 'pdf' || $mimeType !== 'pdf') {
      Response::error('Invalid file type. Only PDF files are allowed.', 400);
      exit;
    }

    if (!$this->isResultsMagicNumberValid()) {
      Response::error('Invalid file magic number. The file may be corrupted or not a valid PDF.', 400);
      exit;
    }

    if ($_FILES["results"]["size"] > 8000000) {
      Response::error('File size exceeds the limit of 8MB.', 400);
      exit;
    }

    if (!move_uploaded_file($_FILES["results"]["tmp_name"], $targetFile)) {
      Response::error('Failed to upload results file.', 500);
      exit;
    }
  }

  public function deleteResults($tournament_id)
  {
    $tournament_name = $tournament_id === 6 ? 'state' : (string) $tournament_id;

    $targetFile = PROJECT_ROOT . "/tournaments/icda-$tournament_name/results.pdf";
    if (file_exists($targetFile)) {
      if (!unlink($targetFile)) {
        Response::error('Failed to delete results file.', 500);
        exit;
      }
    } else {
      Response::error('Results file does not exist.', 404);
      exit;
    }
  }

  public function uploadArchiveResults($archive_id, $tournament_id)
  {
    $season = $this->getSeason($archive_id);

    $tournament_name = $tournament_id === 6 ? 'state' : (string) $tournament_id;

    $targetFile = PROJECT_ROOT . "/archive/$season/icda-$tournament_name-results.pdf";
    $uploadedFile = $_FILES["results"]["name"];

    $uploadedType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));
    $mimeType = str_replace("application/", "", mime_content_type($_FILES["results"]["tmp_name"]));

    if ($uploadedType !== 'pdf' || $mimeType !== 'pdf') {
      Response::error('Invalid file type. Only PDF files are allowed.', 400);
      exit;
    }

    if (!$this->isResultsMagicNumberValid()) {
      Response::error('Invalid file magic number. The file may be corrupted or not a valid PDF.', 400);
      exit;
    }

    if ($_FILES["results"]["size"] > 8000000) {
      Response::error('File size exceeds the limit of 8MB.', 400);
      exit;
    }

    if (!move_uploaded_file($_FILES["results"]["tmp_name"], $targetFile)) {
      Response::error('Failed to upload results file.', 500);
      exit;
    }
  }

  public function deleteArchiveResults($archive_id, $tournament_id)
  {
    $season = $this->getSeason($archive_id);

    $tournament_name = $tournament_id === 6 ? 'state' : (string) $tournament_id;

    $targetFile = PROJECT_ROOT . "/archive/$season/icda-$tournament_name-results.pdf";

    if (file_exists($targetFile)) {
      if (!unlink($targetFile)) {
        Response::error('Failed to delete results file.', 500);
        exit;
      }
    } else {
      Response::error('Results file does not exist.', 404);
      exit;
    }
  }

  public function uploadConstitution()
  {
    $targetFile = PROJECT_ROOT . "/constitution.pdf";
    $uploadedFile = $_FILES["constitution"]["name"];

    $uploadedType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));
    $mimeType = str_replace("application/", "", mime_content_type($_FILES["constitution"]["tmp_name"]));

    if ($uploadedType !== 'pdf' || $mimeType !== 'pdf') {
      Response::error('Invalid file type. Only PDF files are allowed.', 400);
      exit;
    }

    if (!$this->isConstitutionMagicNumberValid()) {
      Response::error('Invalid file magic number. The file may be corrupted or not a valid PDF.', 400);
      exit;
    }

    if ($_FILES["constitution"]["size"] > 8000000) {
      Response::error('File size exceeds the limit of 8MB.', 400);
      exit;
    }

    if (!move_uploaded_file($_FILES["constitution"]["tmp_name"], $targetFile)) {
      Response::error('Failed to update constitution.', 500);
      exit;
    }
  }

  public function uploadImage(): string
  {
    $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'tiff', 'ico', 'avif', 'heic'];
    $mimeType = str_replace("image/", "", mime_content_type($_FILES["image"]["tmp_name"]));

    $targetDir = PROJECT_ROOT . "/public/uploads/";
    $targetFile = $targetDir . '/' . uniqid("", true) . '.' . $mimeType;

    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
      Response::error('File is not an image.', 400);
      exit;
    }

    // Check file extension
    if (!in_array($imageFileType, $validExtensions) || !in_array($mimeType, $validExtensions)) {
      Response::error('Invalid file type. Only JPG, JPEG, PNG, GIF, WEBP, BMP, TIFF, TIF, ICO, AVIF, and HEIC files are allowed.', 400);
      exit;
    }

    if (!$this->isImageMagicNumberValid($imageFileType)) {
      Response::error('Invalid image magic number. The file may be corrupted or not a valid image.', 400);
      exit;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 8000000) { // 8MB limit
      Response::error('File size exceeds the limit of 8MB.', 400);
      exit;
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
      $relativePath = substr($targetFile, strpos($targetFile, '/public/uploads/'));
      return $relativePath;
    } else {
      Response::error('Failed to upload image.', 500);
      exit;
    }
  }

  public function deleteImage($imagePath)
  {
    if (file_exists(PROJECT_ROOT . $imagePath)) {
      if (unlink(PROJECT_ROOT . $imagePath)) {
      } else {
        Response::error('Failed to delete image.', 500);
        exit;
      }
    } else {
      Response::error('Image does not exist.', 404);
      exit;
    }
  }

  private function getImageHeader($bytes = 12)
  {
    // Need to work for legislation and results too
    $handle = fopen($_FILES['image']['tmp_name'], 'rb');
    $header = fread($handle, $bytes);
    fclose($handle);
    return bin2hex($header); // Convert to hexadecimal for easy comparison
  }

  private function isImageMagicNumberValid($extension)
  {
    $magicNumbers = [
      'jpg' => ['ffd8ff'],
      'jpeg' => ['ffd8ff'],
      'png' => ['89504e470d0a1a0a'],
      'gif' => ['47494638'],
      'bmp' => ['424d'],
      'webp' => ['52494646'], // Must also check for 'WEBP' later
      'tiff' => ['49492a00', '4d4d002a'],
      'ico' => ['00000100'],
      'heic' => ['6674797068656963'],
      'heif' => ['6674797068656966'],
      'avif' => ['6674797061766966'],
      'pdf' => ['25504446'], // PDF magic number
    ];

    $ext = strtolower($extension);
    $header = $this->getImageHeader();

    if (!isset($magicNumbers[$ext])) {
      return false;
    }

    foreach ($magicNumbers[$ext] as $magic) {
      if (strpos($header, $magic) === 0) {
        return true;
      }
    }

    // Special case for WebP: check if 'WEBP' appears at byte 8
    if ($ext === 'webp') {
      $contents = file_get_contents($_FILES['image']['tmp_name'], false, null, 8, 4);
      if ($contents === 'WEBP') {
        return true;
      }
    }

    return false;
  }

  private function isLegislationMagicNumberValid()
  {
    $header = $this->getLegislationHeader();
    return strpos($header, '25504446') === 0; // PDF magic number starts with %PDF
  }

  private function getLegislationHeader($bytes = 12)
  {
    $handle = fopen($_FILES['legislation']['tmp_name'], 'rb');
    $header = fread($handle, length: $bytes);
    fclose($handle);
    return bin2hex($header); // Convert to hexadecimal for easy comparison
  }

  private function isResultsMagicNumberValid()
  {
    $header = $this->getResultsHeader();
    return strpos($header, '25504446') === 0; // PDF magic number starts with %PDF
  }

  private function getResultsHeader($bytes = 12)
  {
    $handle = fopen($_FILES['results']['tmp_name'], 'rb');
    $header = fread($handle, length: $bytes);
    fclose($handle);
    return bin2hex($header); // Convert to hexadecimal for easy comparison
  }

  private function isConstitutionMagicNumberValid()
  {
    $header = $this->getConstitutionHeader();
    return strpos($header, '25504446') === 0; // PDF magic number starts with %PDF
  }

  private function getConstitutionHeader($bytes = 12)
  {
    $handle = fopen($_FILES['constitution']['tmp_name'], 'rb');
    $header = fread($handle, length: $bytes);
    fclose($handle);
    return bin2hex($header); // Convert to hexadecimal for easy comparison
  }

}