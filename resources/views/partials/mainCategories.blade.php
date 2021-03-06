@php
$type = session()->get('type') == 'null' ? 'hemp' : session()->get('type');
$country = session()->get('country') == 'null' ? ["dropdown" => "all", "fullName" => "All states"] :
json_decode(session()->get('country'), true);
$isloggedin = empty($_COOKIE['_main']) && !auth()->user() && $type == "cannabis" ? false : true;
if(!$isloggedin){
$div = "<div class='desktop-user-cannabis-error'>
    <h3><span>!</span>Please <a href='http://account.janeverde.com'>log in</a> to view Cannabis posts</h3>
    <div class='forbidden-access-cannabis'>
        
        <div class='home-categories'>

            <div class='home-categories__item'>
                <div class='category-item' data-category='sale'>
                    <h5><a href='javascript:;'>For Sale</a></h5>
                    <ul>
                        <li><a href='javascript:;'>Biomass</a></li>
                        <li><a href='javascript:;'>Concentrates</a></li>
                        <li><a href='javascript:;'>Retail Products</a></li>
                        <li><a href='javascript:;'>Grow Equipment/Supplies</a></li>
                        <li><a href='javascript:;'>Lab Equipment Supplies</a></li>
                        <li><a href='javascript:;'>Promotional</a></li>
                        <li><a href='javascript:;'>In Search of</a></li>
                    </ul>
                </div>
            </div>

            <div class='home-categories__item'>
                <div class='category-item' data-category='misc'>
                    <h5><a href='javascript:;'>Misc</a></h5>
                    <ul>
                        <li><a href='javascript:;'>Events / Promotional</a></li>
                        <li><a href='javascript:;'>Groups / Activities</a></li>
                        <li><a href='javascript:;'>Groups / Clubs / Memberships</a></li>
                        <li><a href='javascript:;'>General</a></li>
                    </ul>
                </div>
            </div>

            <div class='home-categories__item'>
                <div class='category-item' data-category='vendor-listings'>
                    <h5><a href='javascript:;'>Vendor Listings</a></h5>
                    <ul>'
                        <li><a href='javascript:;'>Other</a></li>
                        <li><a href='javascript:;'>Point of Sale</a></li>
                        <li><a href='javascript:;'>Equipment Rental</a></li>
                        <li><a href='javascript:;'>Logistics / Trucking</a></li>
                        <li><a href='javascript:;'>Labor</a></li>
                        <li><a href='javascript:;'>Attorney</a></li>
                        <li><a href='javascript:;'>Marketing / Advertising</a></li>
                        <li><a href='javascript:;'>Telecom</a></li>
                        <li><a href='javascript:;'>Equipment Manufacturers</a></li>
                        <li><a href='javascript:;'>Consulting</a></li>
                    </ul>
                    <ul>
                        <li><a href='javascript:;'>Sales Brokers</a></li>
                        <li><a href='javascript:;'>Web / Design</a></li>
                        <li><a href='javascript:;'>Insurance</a></li>
                        <li><a href='javascript:;'>Banking</a></li>
                        <li><a href='javascript:;'>Lab Testing</a></li>
                        <li><a href='javascript:;'>Ag Processing Facilities</a></li>
                        <li><a href='javascript:;'>Concentrate Facilities</a></li>
                        <li><a href='javascript:;'>Processing</a></li>
                        <li><a href='javascript:;'>Farms</a></li>
                    </ul>
                </div>
            </div>

            <div class='home-categories__item'>
                <div class='category-item' data-category='forums'>
                    <h5>Discussions / Forums</h5>
                    <ul>
                        <li><a href='javascript:;'>Outdoor Grow</a></li>
                        <li><a href='javascript:;'>Indoor Grow</a></li>
                        <li><a href='javascript:;'>Extraction</a></li>
                        <li><a href='javascript:;'>Lab / Testing</a></li>
                    </ul>
                    <ul>
                        <li><a href='javascript:;'>Production / Distribution</a>
                        </li>
                        <li><a href='javascript:;'>General</a></li>
                    </ul>
                </div>
                <div class='clearfix'></div>
            </div>

            <div class='home-categories__item'>
                <div class='category-item' data-category='jobs'>
                    <h5><a href='javascript:;'>Jobs</a></h5>
                    <ul>
                        <li><a href='javascript:;'>All</a></li>
                        <li><a href='javascript:;'>Agriculture</a></li>
                        <li><a href='javascript:;'>Processing</a></li>
                        <li><a href='javascript:;'>Sales / Marketing</a></li>
                        <li><a href='javascript:;'>Admin / Executive</a></li>
                        <li><a href='javascript:;'>Other/General</a></li>
                        <li><a href='javascript:;'>Distribution</a></li>
                        <li><a href='javascript:;'>Laboratory</a></li>
                    </ul>
                </div>
            </div>


            <div class='home-categories__item'>
                <div class='category-item' data-category='real-estate'>
                    <h5><a href='javascript:;'>Business / Real Estate</a></h5>
                    <ul>
                        <li><a href='javascript:;'>Commercial for Sale</a></li>
                        <li><a href='javascript:;'>Commercial for Rent</a></li>
                        <li><a href='javascript:;'>Land for Sale</a></li>javascript:;
                        <li><a href='javascript:;'>Business for Sale</a></li>
                        <li><a href='javascript:;'>Investment Opportunities</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>";
    }
    @endphp
    <div class="home-wrap__item">
        <div class="current-state-heading">
            <div class="current-state-heading__item">
                <h3>{{$country['fullName']}} / <span>{{strtoupper($type)}}</span></h3>
            </div>
            <div class="current-state-heading__item current-state-heading__desktop">
                <form method="GET" action="/{{$type}}/0/0/search">
                    <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
                    <button type="submit">
                        <img src="{{asset('images/search_white.svg')}}" alt="Jane Verde SVG Icon" />
                    </button>
                </form>
            </div>
        </div>

        @if(!$isloggedin)
        {!! $div !!}
        @else

        <div class="home-categories">

            {{-- First Row --}}

            <div class="home-categories__item">
                <div class="category-item" data-category="sale">
                    <h5><a href="/{{$type}}/7395/0/search">For Sale</a></h5>
                    <ul>
                        <li><a href="/{{$type}}/7395/4296/search">Biomass</a></li>
                        <li><a href="/{{$type}}/7395/6581/search">Concentrates</a></li>
                        <li><a href="/{{$type}}/7395/4617/search">Retail Products</a></li>
                        <li><a href="/{{$type}}/7395/4537/search">Grow Equipment/Supplies</a></li>
                        <li><a href="/{{$type}}/7395/4184/search">Lab Equipment Supplies</a></li>
                        <li><a href="/{{$type}}/7395/2971/search">Promotional</a></li>
                        <li><a href="/{{$type}}/7395/2073/search">In Search of</a></li>
                    </ul>
                </div>
            </div>

            <div class="home-categories__item">
                <div class="category-item" data-category="misc">
                    <h5><a href="/{{$type}}/5655/0/search">Misc</a></h5>
                    <ul>
                        <li><a href="/{{$type}}/5655/2572/search">Events / Promotional</a></li>
                        <li><a href="/{{$type}}/5655/2724/search">Groups / Activities</a></li>
                        <li><a href="/{{$type}}/5655/3824/search">Groups / Clubs / Memberships</a></li>
                        <li><a href="/{{$type}}/5655/6095/search">General</a></li>
                    </ul>
                </div>
            </div>

            {{-- End First Row --}}

            {{-- Second Row --}}

            <div class="home-categories__item">
                <div class="category-item" data-category="vendor-listings">
                    <h5><a href="/{{$type}}/4712/0/search">Vendor Listings</a></h5>
                    <ul>
                        <li><a href="/{{$type}}/4712/4644/search">Other</a></li>
                        <li><a href="/{{$type}}/4712/4715/search">Point of Sale</a></li>
                        <li><a href="/{{$type}}/4712/5981/search">Equipment Rental</a></li>
                        <li><a href="/{{$type}}/4712/8788/search">Logistics / Trucking</a></li>
                        <li><a href="/{{$type}}/4712/9121/search">Labor</a></li>
                        <li><a href="/{{$type}}/4712/4910/search">Attorney</a></li>
                        <li><a href="/{{$type}}/4712/5777/search">Marketing / Advertising</a></li>
                        <li><a href="/{{$type}}/4712/3285/search">Telecom</a></li>
                        <li><a href="/{{$type}}/4712/7854/search">Equipment Manufacturers</a></li>
                        <li><a href="/{{$type}}/4712/1090/search">Consulting</a></li>
                    </ul>
                    <ul>
                        <li><a href="/{{$type}}/4712/6000/search">Sales Brokers</a></li>
                        <li><a href="/{{$type}}/4712/2528/search">Web / Design</a></li>
                        <li><a href="/{{$type}}/4712/9132/search">Insurance</a></li>
                        <li><a href="/{{$type}}/4712/4764/search">Banking</a></li>
                        <li><a href="/{{$type}}/4712/7856/search">Lab Testing</a></li>
                        <li><a href="/{{$type}}/4712/4112/search">Ag Processing Facilities</a></li>
                        <li><a href="/{{$type}}/4712/8090/search">Concentrate Facilities</a></li>
                        <li><a href="/{{$type}}/4712/3331/search">Processing</a></li>
                        <li><a href="/{{$type}}/4712/2057/search">Farms</a></li>
                    </ul>
                </div>
            </div>

            <div class="home-categories__item">
                <div class="category-item" data-category="forums">
                    <h5>Discussions / Forums</h5>
                    <ul>
                        <li><a href="javascript:;">Outdoor Grow</a></li>
                        <li><a href="javascript:;">Indoor Grow</a></li>
                        <li><a href="javascript:;">Extraction</a></li>
                        <li><a href="javascript:;">Lab / Testing</a></li>
                    </ul>
                    <ul>
                        <li><a href="javascript:;">Production / Distribution</a>
                        </li>
                        <li><a href="javascript:;">General</a></li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>

            {{-- End Second Row --}}

            {{-- Third Row --}}

            <div class="home-categories__item">
                <div class="category-item" data-category="jobs">
                    <h5><a href="/{{$type}}/1210/0/search">Jobs</a></h5>
                    <ul>
                        <li><a href="/{{$type}}/1210/5191/search">All</a></li>
                        <li><a href="/{{$type}}/1210/4111/search">Agriculture</a></li>
                        <li><a href="/{{$type}}/1210/3043/search">Processing</a></li>
                        <li><a href="/{{$type}}/1210/6999/search">Sales / Marketing</a></li>
                        <li><a href="/{{$type}}/1210/2350/search">Admin / Executive</a></li>
                        <li><a href="/{{$type}}/1210/6762/search">Other/General</a></li>
                        <li><a href="/{{$type}}/1210/5911/search">Distribution</a></li>
                        <li><a href="/{{$type}}/1210/6509/search">Laboratory</a></li>
                    </ul>
                </div>
            </div>


            <div class="home-categories__item">
                <div class="category-item" data-category="real-estate">
                    <h5><a href="/{{$type}}/3098/0/search">Business / Real Estate</a></h5>
                    <ul>
                        <li><a href="/{{$type}}/3098/2152/search">Commercial for Sale</a></li>
                        <li><a href="/{{$type}}/3098/5266/search">Commercial for Rent</a></li>
                        <li><a href="/{{$type}}/3098/2340/search">Land for Sale</a></li>
                        <li><a href="/{{$type}}/3098/3668/search">Business for Sale</a></li>
                        <li><a href="/{{$type}}/3098/6150/search">Investment Opportunities</a></li>
                    </ul>
                </div>
            </div>

            {{-- End Third Row --}}
        </div>
        @endif
    </div>