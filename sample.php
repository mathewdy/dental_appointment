<?php


$conn = new mysqli ("localhost", "root" , "", "dental_system");

if($conn == false){
    echo "not connected". $conn->error;
}

$query_name = "SELECT * FROM users LIMIT 1";
    $run_name = mysqli_query($conn,$query_name);
    if(mysqli_num_rows($run_name) > 0){
       $row =mysqli_fetch_assoc($run_name);
      echo $row['first_name'];
      echo $row['last_name'];
      echo $row['mobile_number'];
      echo $row['email'];
    }


require_once('vendor/autoload.php');
$client = new \GuzzleHttp\Client();

$data = [
  "data" => [
    "attributes" => [
      "amount" => 10056,
      "description" => "Dental Appointment Payment",
      "remarks" => "Booking Ref #12345",
      "redirect" => [
        "success" => "http://localhost/dental_appointment/success.php",
        "failed" => "http://localhost/dental_appointment/failure.php"
      ],
      "currency" => "PHP"
    ]
  ]
];


$response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
  'headers' => [
    'accept' => 'application/json',
    'authorization' => 'Basic c2tfdGVzdF9ycUdpaVJUdUY4TGpneUx1UlF6YnFQZ1c6',
    'content-type' => 'application/json',
  ],
  'body' => json_encode($data),
]);

$responseData = json_decode($response->getBody(), true);
$paymentLink = $responseData['data']['attributes']['checkout_url'];

echo "<a href='payment.php' target='_blank'>Click here to pay</a>";