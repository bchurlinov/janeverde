@php
$type = session()->get('type') == 'null' ? 'cannabis' : session()->get('type');
$country = session()->get('country') == 'null' ? ["dropdown" => "all", "fullName" => "All states"] : json_decode(session()->get('country'), true);
@endphp
<div class="home-wrap__item">
    <div class="current-state-heading">
        <div class="current-state-heading__item">
            <h3>{{$country['fullName']}} / <span>{{strtoupper($type)}}</span></h3>
        </div>
        <div class="current-state-heading__item current-state-heading__desktop">
            <form method="GET" action="/{{$type}}/0/search">
                <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
                <button type="submit">
                    <img src="{{asset('images/search_white.svg')}}" alt="Jane Verde SVG Icon" />
                </button>
            </form>
        </div>
    </div>

    <div class="home-categories">
        <div class="home-categories__item">
            <div class="category-item" data-category="forums">
                <h5>Discussions / Forums</h5>
                <ul>
                    <li><a href="/search" >Outdoor Grow</a></li>
                    <li><a href="/search" >Indoor Grow</a></li>
                    <li><a href="/search" >Extraction</a></li>
                    <li><a href="/search" >Lab / Testing</a></li>
                </ul>
                <ul>
                    <li><a href="/search" >Production / Distribution</a>
                    </li>
                    <li><a href="/search" >General</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="home-categories__item">
            <div class="category-item" data-category="vendor-listings">
                <h5>Vendor Listings</h5>
                <ul>
                    <li><a href="/search" >Legal / Attorney</a></li>
                    <li><a href="/search" >Account / Bank</a></li>
                    <li><a href="/search" >Web / Design</a></li>
                    <li><a href="/search" >Brokers</a></li>
                    <li><a href="/search" >Consulting</a></li>
                    <li><a href="/search" >Tolling Facilities</a></li>
                </ul>
                <ul>
                    <li><a href="/search" >Lab / Testing</a></li>
                    <li><a href="/search" >Equipment / Manufacturers</a>
                    </li>
                    <li><a href="/search" >Telecom</a></li>
                    <li><a href="/search" >Labor</a></li>
                    <li><a href="/search" >Marketing</a></li>
                    <li><a href="/search" >General</a></li>
                </ul>
            </div>
        </div>

        <div class="home-categories__item">
            <div class="category-item" data-category="sale">
                <h5>For Sale</h5>
                <ul>
                    <li><a href="/{{$type}}/4296/search" >Biomass</a></li>
                    <li><a href="/{{$type}}/6581/search" >Concentrates</a></li>
                    <li><a href="/{{$type}}/4617/search" >Retail Products</a></li>
                    <li><a href="/{{$type}}/4537/search" >Grow Equipment</a></li>
                    <li><a href="/{{$type}}/4184/search" >Lab Equipment</a></li>
                    <li><a href="/{{$type}}/2971/search" >Promotional</a></li>
                    <li><a href="/{{$type}}/2073/search" >Misc</a></li>
                </ul>
            </div>
        </div>

        <div class="home-categories__item">
            <div class="category-item" data-category="misc">
                <h5>Misc</h5>
                <ul>
                    <li><a href="/{{$type}}/2572/search" >Events / Promotional</a></li>
                    <li><a href="/{{$type}}/2724/search" >Groups / Activities</a></li>
                    <li><a href="/{{$type}}/3824/search" >General</a></li>
                </ul>
            </div>
        </div>

        <div class="home-categories__item">
            <div class="category-item" data-category="real-estate">
                <h5>Real Estate</h5>
                <ul>
                    <li><a href="/{{$type}}/2152/search" >Commercial for Sale</a></li>
                    <li><a href="/{{$type}}/5266/search" >Commercial for Rent</a></li>
                    <li><a href="/{{$type}}/2340/search" >Farm / Land</a></li>
                </ul>
            </div>
        </div>

        <div class="home-categories__item">
            <div class="category-item" data-category="jobs">
                <h5>Jobs</h5>
                <ul>
                    <li><a href="/{{$type}}/3668/search" >Grow Indoor</a></li>
                    <li><a href="/{{$type}}/6150/search" >Grow Outdoor</a></li>
                    <li><a href="/{{$type}}/4111/search" >Trimming</a></li>
                    <li><a href="/{{$type}}/3043/search" >Hemp Extract</a></li>
                    <li><a href="/{{$type}}/6999/search" >THC Extract</a></li>
                    <li><a href="/{{$type}}/2350/search" >Drying</a></li>
                    <li><a href="/{{$type}}/6762/search" >Sales</a></li>
                    <li><a href="/{{$type}}/5191/search" >Marketing</a></li>
                    <li><a href="/{{$type}}/6095/search" >Business</a></li>
                    <li><a href="/{{$type}}/4644/search" >Admin</a></li>
                </ul>
                <ul>
                    <li><a href="/{{$type}}/4715/search" >Design / Web</a></li>
                    <li><a href="/{{$type}}/5981/search" >Retail</a></li>
                    <li><a href="/{{$type}}/4013/search" >Distribution</a></li>
                    <li><a href="/{{$type}}/2585/search" >Laboratory</a></li>
                    <li><a href="/{{$type}}/6291/search" >Regulatory</a></li>
                    <li><a href="/{{$type}}/3262/search" >Construction</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>