@php
use App\User;
$country = json_decode(session()->get('country'), true);
$cookieSet = session()->get('type') == null ? "hemp" : session()->get('type');

$type = session()->get('type') == 'null' ? 'hemp' : session()->get('type');
$country = session()->get('country') == 'null' ? ["dropdown" => "all", "fullName" => "All states"] :
json_decode(session()->get('country'), true);
$isloggedin = empty($_COOKIE['_main']) && !auth()->user() && $type == "cannabis" ? false : true;
if(!$isloggedin){
$div = "<div class='mobile-user-cannabis-error'>
    <h3><span>!</span>Please <a href='http://account.janeverde.com'>log in</a> to view Cannabis products</h3>
</div>";
}

//check for logged in user
$showVerifyLink = false;
$user = 0;
if(!empty($_COOKIE['_main']) || auth()->user() != null){
if(!empty($_COOKIE['_main'])){
$user = $_COOKIE['_main'];
$user = User::find($user);
if($user != null && $user->verification_step_1 == 0){
$showVerifyLink = true;
}
}
}
@endphp


<div class="container">
    <div class="outer-wrap outer-wrap-mobile">
        <div class="welcome-user-mobile">
            <p>@include('partials.userAndLogout')</p>
        </div>
        <div class="clearfix"></div>
        <!-- Mobile Version  -->
        <div class="home-wrap-mobile">
            <div class="home-wrap-mobile__navbar">
                <div>
                    <h1><a href="/">jane <span>Verde</span></a></h1>
                </div>
                <div>
                    <a href="{{config('variables.reacturl')}}/post" class="button-link">Create Listing</a>
                    <a href="{{config('variables.reacturl')}}" class="button-link">My Account</a>
                </div>
            </div>

            <div class="home-wrap-mobile__togles">
                <div class="toggle-countries">
                    <div class="hemp-cannabis-toggle">
                        <button class="ctype {{$cookieSet == "hemp" ? "toggle-active" : ""}}" id="hemp">HEMP</button>
                        <button class="ctype {{$cookieSet == "cannabis" ? "toggle-active" : "" }}"
                            id="cannabis">CANNABIS</button>
                    </div>
                </div>

                <div class="selectric-mobile">
                    @if (request()->segment(1) !== "view")
                    <select id="select-states-mobile"></select>
                    @endif
                </div>

                <div class="search-mobile">
                    <div class="current-state-heading__item">
                        <form method="GET" action="/{{session()->get('type')}}/0/0/search">
                            <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
                            <button type="submit">
                                <img src={{asset('images/search_white.svg')}} alt="Jane Verde SVG Image" />
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if(!$isloggedin)
            {!! $div !!}
            @else

            <div data-category="mobile-categories">

                <div class="mobile-categories__item" data-click="sale" data-category="sale"
                    onclick="toggleCategory(this)">
                    <h4>For Sale
                        <span>
                            <i class="fas fa-chevron-down" data-clicked="sale"></i>
                        </span>
                    </h4>
                    <div data-target="sale">
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

                <div class="mobile-categories__item" data-click="jobs" data-category="jobs"
                    onclick="toggleCategory(this)">
                    <h4>Jobs
                        <span>
                            <i class="fas fa-chevron-down" data-clicked="jobs"></i>
                        </span>
                    </h4>
                    <div data-target="jobs">
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

                <div class="mobile-categories__item" data-click="real-estate" data-category="real-estate"
                    onclick="toggleCategory(this)">
                    <h4>Real Estate
                        <span>
                            <i class="fas fa-chevron-down" data-clicked="real-estate"></i>
                        </span>
                    </h4>
                    <div data-target="real-estate">
                        <ul>
                            <li><a href="/{{$type}}/3098/2152/search">Commercial for Sale</a></li>
                            <li><a href="/{{$type}}/3098/5266/search">Commercial for Rent</a></li>
                            <li><a href="/{{$type}}/3098/2340/search">Land for Sale</a></li>
                            <li><a href="/{{$type}}/3098/3668/search">Business for Sale</a></li>
                            <li><a href="/{{$type}}/3098/6150/search">Investment Opportunities</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mobile-categories__item" data-click="vendor-listings" data-category="vendor-listings"
                    onclick="toggleCategory(this)">
                    <h4>Vendor Listings
                        <span>
                            <i class="fas fa-chevron-down" data-clicked="vendor-listings"></i>
                        </span>
                    </h4>
                    <div data-target="vendor-listings">
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

                <div class="mobile-categories">
                    <div class="mobile-categories__item" data-category="forums" data-click="discussions-forums"
                        onclick="toggleCategory(this)">
                        <h4>Discussions / Forums
                            <span>
                                <i class="fas fa-chevron-down" data-clicked="discussions-forums"></i>
                            </span>
                        </h4>
                        <div data-target="discussions-forums">
                            <ul>
                                <li><a href="javascript:;">Outdoor Grow</a></li>
                                <li><a href="javascript:;">Indoor Grow</a></li>
                                <li><a href="javascript:;">Extraction</a></li>
                                <li><a href="javascript:;">Lab / Testing</a></li>
                                <li><a href="javascript:;">Production / Distribution</a></li>
                                <li><a href="javascript:;">General</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="mobile-categories__item" data-click="misc" data-category="misc"
                        onclick="toggleCategory(this)">
                        <h4>Misc
                            <span>
                                <i class="fas fa-chevron-down" data-clicked="misc"></i>
                            </span>
                        </h4>
                        <div data-target="misc">
                            <ul>
                                <li><a href="/{{$type}}/5655/2572/search">Events / Promotional</a></li>
                                <li><a href="/{{$type}}/5655/2724/search">Groups / Activities</a></li>
                                <li><a href="/{{$type}}/5655/3824/search">Groups / Clubs / Memberships</a></li>
                                <li><a href="/{{$type}}/5655/6095/search">General</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
                @endif


            </div>
        </div>
    </div>
</div>