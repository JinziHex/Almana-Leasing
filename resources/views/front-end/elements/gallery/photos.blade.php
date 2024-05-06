<!DOCTYPE html>
<html>

<head>
    <title>Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Fira+Sans:400,700">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <style type="text/css">
        /* Start Gallery CSS */
        .thumb {
            margin-bottom: 15px;
        }

        .thumb:last-child {
            margin-bottom: 0;
        }

        /* CSS Image Hover Effects: https://www.nxworld.net/tips/css-image-hover-effects.html */
        .thumb figure img {
            -webkit-transition: .3s ease-in-out;
            transition: .3s ease-in-out;
            border: none;
            padding: 0;
            height: 175px;
            object-fit: cover;
            width: 100%;
        }

        .thumb figure:hover img {
            -webkit-filter: grayscale(0);
            filter: grayscale(0);

        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid white;
            background-color: white;
        }



        /* Style the buttons inside the tab */

        .tab button.tablinks-tab {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 10px 16px;
            transition: 0.3s;
            font-size: 17px;
            color: black;
            min-width: 90px;
            text-align: center;
        }

        /* Change background color of button.tablinks-tabs on hover */
        /*.tab button.tablinks-tab:hover {
		    background-color: #ececec;
		}*/

        /* Create an active/current tablink class */
        .tab button.tablinks-tab.active-tab {
            background-color: #e61e26;
            color: white;
        }

        /* Style the tab content */
        .tabcontent-tab {
            display: none;
            padding: 6px 12px;
            border-top: none;
        }

        section.tabbedGallery {
            padding-top: 100px;
            padding-bottom: 100px;
        }

        .thumb h3 {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            background: #00000082;
        }

        .thumb a {
            position: relative;
        }

        .thumb a:hover h3 {
            display: flex;
            color: white;
            z-index: 99;
            font-size: 20px;
            background: #00000099;
        }

        .gallery {
            padding: 30px 0 10px;
        }

        /*********************************************************/

        @media only screen and (max-width: 768px) {
            .thumb figure img {
                height: 220px;
                object-fit: cover;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <section class="container tabbedGallery">
        <!-- tab -->
        <!--<div class="tab">-->
        <!--    <button class="tablinks-tab" onclick="openTab(event, 'tab1')" id="defaultOpen">London</button>-->
        <!--    <button class="tablinks-tab" onclick="openTab(event, 'tab2')">Paris</button>-->
        <!--    <button class="tablinks-tab" onclick="openTab(event, 'tab3')">Tokyo</button>-->
        <!--</div>-->

        <div id="tab1">
            <!-- tab gallery -->
            <div class="row gallery">
                 @foreach($photos as $photo)
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <a href="{{url('public/assets/uploads/album/photo/'.$photo->photo_image)}}">
                        <h3> {{ $photo->photo_title }} </h3>
                        <figure><img class="img-fluid img-thumbnail" src="{{url('assets/uploads/album/photo/'.$photo->photo_image)}}" alt="Random Image"></figure>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.5/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".gallery").magnificPopup({
                delegate: "a",
                type: "image",
                tLoading: "Loading image #%curr%...",
                mainClass: "mfp-img-mobile",
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
                }
            });
        });
    </script>
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent-tab");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks-tab");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active-tab", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active-tab";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>
</body>

</html>