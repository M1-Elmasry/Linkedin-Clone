<?php

function base_path($path)
{
  return $_SERVER['DOCUMENT_ROOT'] . "/" .$path;
}

function abort($code = 404)
{
  http_response_code($code);
  echo "Status Code: {$code}";
}