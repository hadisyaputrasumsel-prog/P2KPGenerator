<?php
function read_docx($filename){
    $content = '';
    if(!$filename || !file_exists($filename)) return false;

    $zip = new ZipArchive;
    if ($zip->open($filename) === TRUE) {
        if (($index = $zip->locateName('word/document.xml')) !== false) {
            $data = $zip->getFromIndex($index);
            $xml = new DOMDocument();
            $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $content = $xml->saveXML();
            
            // Basic text extraction from XML
            $content = strip_tags($content, '<w:p><w:t>');
            $content = preg_replace('/<w:p[^>]*>/', "\n", $content);
            $content = strip_tags($content);
        }
        $zip->close();
    }
    return $content;
}

$file = $argv[1];
echo read_docx($file);
