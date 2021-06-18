<?php

use Illuminate\Support\Facades\Log;

if( ! function_exists('unique_random') ){
    /**
     *
     * Generate a unique random string of characters
     * uses str_random() helper for generating the random string
     *
     * @param     $table - name of the table
     * @param     $col - name of the column that needs to be tested
     * @param int $chars - length of the random string
     *
     * @return string
     */
    function unique_random($table, $col, $chars = 16, $number = false){

        $unique = false;

        // Store tested results in array to not test them again
        $tested = [];

        do{

            if ($number) {
              $random = '';
              for ($i = 0; $i<$chars; $i++) 
              {
                $random .= mt_rand(0,9);
              }
            } else {
              // Generate random string of characters
              $random = str_random($chars);
            }

            // Check if it's already testing
            // If so, don't query the database again
            if( in_array($random, $tested) ){
                continue;
            }

            // Check if it is unique in the database
            $count = DB::table($table)->where($col, '=', $random)->count();

            // Store the random character in the tested array
            // To keep track which ones are already tested
            $tested[] = $random;

            // String appears to be unique
            if( $count == 0){
                // Set unique to true to break the loop
                $unique = true;
            }

            // If unique is still false at this point
            // it will just repeat all the steps until
            // it has generated a random string of characters

        }
        while(!$unique);


        return $random;
    }
}

if (! function_exists('mergeArrays')) {
    function mergeArrays($Arr1, $Arr2)
    {
      foreach($Arr2 as $key => $Value)
      {
        if(array_key_exists($key, $Arr1) && is_array($Value))
          $Arr1[$key] = MergeArrays($Arr1[$key], $Arr2[$key]);

        else
          $Arr1[$key] = $Value;

      }

      return $Arr1;
    }
}

if (! function_exists('base64Image')) {

  function base64Image($base64_image)
  {
    if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
      $data = substr($base64_image, strpos($base64_image, ',') + 1);

      return base64_decode($data);
    }

    return base64_decode($base64_image);
  }
}

if (! function_exists('base64ImageSort')) {

  function base64ImageSort($base64_image)
  {
    if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
      $data = substr($base64_image, strpos($base64_image, ',') + 1);

      return $data;
    }

    return $base64_image;
  }
}

if (! function_exists('formatBytes')) {

  function formatBytes($bytes)
  {
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
  }
}

if (! function_exists('telegram')){
    /**
     * Send note to developers with Telegram.
     *
     * @param $note
     */
    function telegram($note)
    {
        $token = env('TELEGRAM_LOGGER_TOKEN');
        $chat_id = env('TELEGRAM_LOGGER_CHAT_ID');
        $message = '<b>' . env('APP_NAME') . '</b>' . PHP_EOL
            . '<b>' . env('APP_ENV') . '</b>' . PHP_EOL
            . '<i>Message:</i>' . PHP_EOL
            . '<code>' . $note . '</code>';
        try {
            $ids = explode(',', $chat_id);
            foreach ($ids as $id) {
                file_get_contents(
                    'https://api.telegram.org/bot' . $token . '/sendMessage?'
                    . http_build_query([
                        'text' => $message,
                        'chat_id' => $id,
                        'parse_mode' => 'html'
                    ])
                );
            }
        } catch (\Exception $e) {
            Log::error('TelegramLog bad token/chat_id.');
        }
    }
}