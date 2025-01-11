<?php

class QrCode
{
    private $text;
    private $size = 300;
    private $encoding = 'UTF-8';

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getEncoding()
    {
        return $this->encoding;
    }

    public function write(PngWriter $writer)
    {
        return $writer->write($this);
    }
}

class PngWriter
{
    public function write(QrCode $qrCode)
    {
        // Pastikan ekstensi GD diaktifkan
        if (!function_exists('imagecreate')) {
            throw new Exception('Fungsi GD imagecreate tidak ditemukan. Pastikan ekstensi GD diaktifkan.');
        }

        $qrCodeImage = imagecreate($qrCode->getSize(), $qrCode->getSize());
        $backgroundColor = imagecolorallocate($qrCodeImage, 255, 255, 255);
        $blackColor = imagecolorallocate($qrCodeImage, 0, 0, 0);

        // Menambahkan logika untuk menggambar QR Code (implementasi penyederhanaan)
        // Dalam penerapan sesungguhnya, Anda akan membutuhkan generator QR yang lebih kompleks

        // Menyimpan QR Code sebagai gambar PNG
        ob_start();
        imagepng($qrCodeImage);
        $imageData = ob_get_clean();
        imagedestroy($qrCodeImage);

        return new PngImage($imageData);
    }
}

class PngImage
{
    private $imageData;

    public function __construct($imageData)
    {
        $this->imageData = $imageData;
    }

    public function getString()
    {
        return $this->imageData;
    }
}
?>
