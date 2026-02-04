@extends('products/layout')



@push('style')
    <style>
        .homeVid
        {
            width: 100vw;   
            height: 100vh;
            position: relative;
            margin-top: 0px;
            margin-bottom: 20px;
        }



        video
        {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;   
            height: 100%;  
            object-fit: cover; 
            z-index: -1;
        }


        .imgshow
        {
            width: 1320px;   
            height: 100vh;
            position: relative;
            margin-top: 0px;
            /* margin-bottom: 30px; */
            margin-left: 15px;
            border-radius: 10px;
            overflow-x: hidden;


        }

        .show
        {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;   
            height: 100%;  
            object-fit: cover; 
            z-index: -1;
            border-radius: 20px;

        }

        .imgOffer
        {
            /* background-color: black; */
            width: 1320px;   
            height: 100vh;
            position: relative;
            margin-top: 0px;
            margin-bottom: 20px;
            margin-left: 15px;
            border-radius: 10px;
            overflow-x: hidden;


        }

        .offer
        {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;   
            height: 100%;  
            object-fit: cover; 
            z-index: -1;
            border-radius: 20px;
        }


        .categories
        {
            background-color: black;
            margin-bottom: 20px;
            padding: 30px;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            position: relative;




        }

        .imgPolo,.imgTshirt,.imgShirt
        {
            width: 350px;
            height: 550px;
            /* background-color: rgb(255, 0, 191); */
            border-radius: 20px;
            overflow: hidden;
            position: relative;

        }

        .cats
        {
            width: 100%;   
            height: 100%;   
            object-fit: cover; 
            z-index: -1;
            border-radius: 20px;
            transition: .6s;
        }

        .cats:hover
        {
            transform: scale(1.1);
        }

        .Slogo
        {
            position: absolute;
            width: 100px;
            height: 100px;
            top: 0;
            left: 0;

        }

        .imgStock
        {
            width: 100vw;   
            height: 100vh;
            position: relative;
            margin-top: 0px;
            overflow-x: hidden;

        }

        .stock{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;   
            height: 100%;  
            object-fit: cover; 
            z-index: -1;

        }


        @media screen and (max-width:600px) 
        {


            .offer
            {
                left: -130px;

            }

            .imgOffer,.imgshow{
                margin-left: 0;
                border-radius: 0;
            }

            .show
            {
                left: -600px;

            }

            .categories
            {
                width: 455px;
                flex-direction: column;
                gap: 20px;
                align-items: center;

            }



            





        }


    </style>
@endpush

@section('content')


    <div class="homeVid">
      <video src="home img&vid/home video.mp4" autoplay loop muted></video>
    </div>

    <div class="imgshow">
      <img src="home img&vid/bg2.png" alt="show" class="show" />
    </div>

    <div class="imgOffer">
      <img src="home img&vid/offer.jpg" alt="offer" class="offer" />
    </div>

    <div class="categories">
      <div class="imgPolo">
        <img src="home img&vid/polo.png" alt="polo" class="cats" />
        <img src="home img&vid/black logo.png" alt="" class="Slogo"/>
      </div>
      <div class="imgTshirt">
        <img src="home img&vid/tshirt.png" alt="Tshirt" class="cats" />
        <img src="home img&vid/black logo.png" alt="" class="Slogo"/>
      </div>
      <div class="imgShirt">
        <img src="home img&vid/shirt.png" alt="Shirt" class="cats" />
        <img src="home img&vid/black logo.png" alt="" class="Slogo"/>
      </div>

    </div>

    <div class="imgStock">
      <img src="home img&vid/bg3.png" alt="show" class="stock" />
      <img src="home img&vid/black logo.png" alt="" class="Slogo"/>

    </div>

@endsection