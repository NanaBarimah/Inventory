<?php
   /**
    * Created by Visual Studio Code.
    * User: Barimah
    * Date: 2/24/2019
    * Time: 2:44 AM
    */

   namespace App;

   use Illuminate\Http\Request;

   /**
    * Class Utils
    * A suite of static methods to enable reuse of helper utilities
    * @package App
    */
   class Utils
   {
      /**
       * Save an uploaded image to the /public/images folder or /public/<new location> directory
       * @param \Illuminate\Http\Request $request
       * @param $key String
       * @param $saveDir String /The directory in the public
       *                 folder where you want the file to be uploaded
       *
       * @return string
       */
      public static function saveImage (Request $request, String $key = 'image', String $saveDir = 'img'): string
      {
         $file     = $request->file($key);
         $fileName = time() . '-' . $file->hashName();

         $file->move($saveDir, $fileName);

         return $fileName;
      }

      public static function saveImageFromDz (Request $request, String $key = 'file', String $saveDir = 'img'): string
      {
         $file     = $request->file($key);
         $file  = $file[0];
         $fileName = time() . '-' . $file->hashName();

         $file->move($saveDir, $fileName);

         return $fileName;
      }

      public static function saveBase64Image($base64_image_string, $output_file_without_extension, $path_with_end_slash="" ) {
         $splited = explode(',', substr( $base64_image_string , 5 ) , 2);
         $mime=$splited[0];
         $data=$splited[1];

         $mime_split_without_base64=explode(';', $mime,2);
         $mime_split=explode('/', $mime_split_without_base64[0],2);
         
         if(count($mime_split)==2)
         {
            $extension=$mime_split[1];
            if($extension=='jpeg')$extension='jpg';
            $output_file_with_extension=$output_file_without_extension.'.'.$extension;
         }

         file_put_contents( $path_with_end_slash . $output_file_with_extension, base64_decode($data) );
         return $output_file_with_extension;
      }
   }