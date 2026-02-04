@extends('products/layout')


@push('style')
    <style>

        .block{
            text-align:center;
            padding:10px;
            margin-bottom:20px;
            background-color:black;
            color:white;
            font-size:20px;
        }
        .container{
            /* background-color:red; */
            position: relative;
            margin-top:20px;
            padding:30px;
            display: grid;
            grid-template-columns: auto auto auto auto;
            gap: 20px;
            
        }
        .card{
            width: 300px;
            height: 500px;
            /* background-color:green; */
            position: relative;
        }
        .imgCon{
            width: 100%;
            height: 80%;
            position: relative;

        }

        .product_img{
                /* position: absolute;
                top: 0;
                left: 0;
                width: 100%;   
                height: 100%;  
                object-fit: cover; 
                z-index: 99; */
                  
                width: 100%;
                height: 100%;
                @foreach($products as $product)
                background-image: url('{{ asset('product_images/'.$product->image1) }}');
                @endforeach
                background-size: cover;
                background-position: center;
                transition: background-image 0.3s ease-in-out;
        }

        

        .product_img:hover {
                 @foreach($products as $product)
                background-image: url('{{ asset('product_images/'.$product->image2) }}');
                @endforeach  
        }

        .sale{
            position: absolute;
            top: 0;
            right: 0;
            background-color:red;
            text-align:center;
            padding:7px;
            font-size:12px;
            z-index: 990;

            

        }
        del{
            color:red;

        }
        p{
            font-size:20px;
        }
        .addTo{
            position: absolute;
            bottom: -10px;
            right: 0;
            width: 90%;
            background-color:yellow;
            text-align:center;
            padding:5%;
            font-size:17px;
            z-index: 990;
            opacity: 0;
            transition:.5s;
            
        }
        .imgCon:hover .addTo{
            opacity: 1;
            bottom: 0;

        }

        .love_icon,.love{
            width:30px ;
            height: 30px;

        }
        .love{
            z-index: 990;
            position: absolute;
            top: 5px;
            left: -5px;
            transition:.5s;
            opacity: 0;
            width: 100px;
            /* background-color:white; */




        }
        .imgCon:hover .love{
            opacity: 1;
            left: 5px;

        }
        .wordAdd{
            position: absolute;
            bottom: 7px;
        }

                @media screen and (max-width:600px) {
                            .container{

            grid-template-columns: auto ;
            justify-content:center;
            
        }

    </style>


@endpush







@section('content')


    @if($products->count())
    <div class="block">Results for {{$query}}</div>

                <div class="container">
        @foreach($products as $product)
        
        <div class="card">
            <div class="imgCon">
                <!-- <img src="{{ asset('product_images/'.$product->image1) }}" alt="product img" class="product_img"> -->
                 <div class="product_img"></div>
                <div class="sale">sale {{$product->sale}}%</div>
                <div class="addTo">Add To Cart</div>
                <div class="love"><img src="{{asset('home img&vid/fav.png')}}" alt="fav" class="love_icon"><span class="wordAdd">add to fav</span></div>
            </div>

            <p>{{$product->name}} - {{$product->color}} </p>

            <p><del>LE {{number_format($product->price,2)}}</del> LE {{number_format($product->price-($product->price*$product->sale/100),2)}}</p>

        </div>
        
        @endforeach
    </div>

    @else
    <div class="block">Not Found Results for {{$query}}</div>





    @endif



@endsection