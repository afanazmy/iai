<?php

function callAPI($method, $url, $data){
   $curl = curl_init();

   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'APIKEY: $2y$10$Qw7lmGEuRvztNG8SaNZyguV74bAQD7xWNJeIeQU.d8/RZU/kKXIju',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}

// GET
// $data = ['nim' => '11547'];
// $get_data = callAPI('GET', '10.33.72.6/book-api/public/register', $data);
// print_r($get_data);

// POST
// $data=  array(
//       "customer"        => $user['User']['customer_id'],
//       "payment"         => array(
//             "number"         => $this->request->data['account'],
//             "routing"        => $this->request->data['routing'],
//             "method"         => $this->request->data['method']
//       ),
// );
$data = [
    'title' => 'Judul',
    'author'=> 'Penulis'
];

$make_call = callAPI('POST', '10.33.72.6/book-api/public/create', json_encode($data));
print_r($make_call);


// PUT
// $data=  array(
//    "amount" => (string)($lease['amount'] / $tenant_count)
// );


// DELETE
// callAPI('DELETE', 'ENDPOINT', false);

$data = ['nim' => '11547'];
$get_data = callAPI('GET', '10.33.72.6/book-api/public/register', $data);
print_r($get_data);

?>
