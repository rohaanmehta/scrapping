<?php

namespace App\Controllers;

class Scrapping extends BaseController
{
    public function scrap()
    {
        // echo 'welcome to the future';

        //defaut
        // $httpClient = new \Goutte\Client();
        // $response = $httpClient->request('GET', 'https://books.toscrape.com/');
        // $titles = $response->evaluate('//ol[@class="row"]//li//article//h3/a');
        // $prices = $response->evaluate('//ol[@class="row"]//li//article//div[@class="product_price"]//p[@class="price_color"]');
        // // we can store the prices into an array
        // $priceArray = [];
        // foreach ($prices as $key => $price) {
        //     $priceArray[] = $price->textContent;
        // }
        // // we extract the titles and display to the terminal together with the prices
        // foreach ($titles as $key => $title) {
        //     echo $title->textContent . ' @ ' . $priceArray[$key] . PHP_EOL.'<br>';
        // }

        // custom
        $httpClient = new \Goutte\Client();
        $response = $httpClient->request('GET', 'https://www.karmaplace.com/collections/menswear');
        $products = $response->evaluate('//div[@class="productitem--info"]//h2/a');
        $price = $response->evaluate('//div[@class="price__current price__current--emphasize "]//span[@class="money"]//span[@class="money"]');
        $csv = "Tittle,price \n";
        // echo '<pre>';print_r($price);exit;
        foreach ($price as  $title) {
            $price_array[] = $title->textContent;
        }
        foreach ($products as  $title) {
            $remove_space = str_replace(' ','',$title->textContent);
            $products_array[] = str_replace("\n",'',$remove_space);
        }
        $i = 0;
        foreach($products_array as $row){
            $csv .= $row.','.$price_array[$i].'
';
            $i++;
        }
        header("Content-type: text/x-csv");
        header("Content-Disposition: attachment; filename=Scrapping.csv");
        echo $csv;
        exit;
    }
}
