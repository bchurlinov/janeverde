@extends("partials.layout")

@section("css_links")

@endsection

@section("content")

<div class="wrapper">
    <div class="container">
        @include('partials.mobileMenu')
        <div class="outer-wrap">
            <div align="right">
                @if(auth()->user())
                {!! "<a href='/dashboard'>" .substr(auth()->user()->name, 0, 1) . " " . substr(auth()->user()->lastname,
                    0, 1) . "</a>" !!}
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @endif
            </div>
            <div class="home-wrap">
                @include('partials.leftMenu')
                <div class="home-wrap__item">
                    <div class="current-state-heading">
                        <div class="current-state-heading__item">
                            <h3>Privacy Policy</h3>
                        </div>
                        <div class="current-state-heading__item">
                            <form method="GET"
                                action="/{{session()->get('type') == 'null' ? 'hemp' : session()->get('type')}}/0/0/search">
                                <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
                                <button type="submit">
                                    <img src="{{asset('images/search_white.svg')}}" alt="Jane Verde SVG Icon" />
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="privacy-policy-content">
                        <h3>Introduction</h3>
                        <p>Jane Verde (“Company” or “We”) respect your privacy and are committed to protecting it
                            through our compliance with this policy.</p>
                        <p>This policy describes the types of information we may collect from you or that you may
                            provide when you visit the website www.janeverde.com (our “Website”) and our practices for
                            collecting, using, maintaining, protecting, and disclosing that information.</p>
                        <p>This policy applies to information we collect:</p>
                        <p>On this Website.</p>
                        <p>In email, text, and other electronic messages between you and this Website.</p>
                        <p>It does not apply to information collected by:</p>
                        <ul>
                            <li>Us offline or through any other means, including on any other website operated by
                                Company or any third party (including our affiliates and subsidiaries); or</li>
                            <li>Any third party (including our affiliates and subsidiaries), including through any
                                application or content (including advertising) that may link or be accessible from the
                                Website.
                            </li>
                        </ul>
                        <p>Please read this policy carefully to understand our policies and practices regarding your
                            information and how we will treat it. If you do not agree with our policies and practices,
                            your choice is not to use our Website. By accessing or using this Website, you agree to this
                            privacy policy. This policy may change from time to time. Your continued use of this Website
                            after we make changes is deemed to be acceptance of those changes, so please check the
                            policy periodically for updates.
                        </p>
                        <h2>Persons Under the Age of 18</h2>
                        <p>Our Website is not intended for persons under 18 years of age. No one under age 18 may
                            provide any information to or on the Website. We do not knowingly collect personal
                            information from persons under 18. If you are under 18, do not use or provide any
                            information on this Website or through any of its features, register on the Website, make
                            any purchases through the Website, use any of the interactive or public comment features of
                            this Website, or provide any information about yourself to us, including your name, address,
                            telephone number, email address, or any screen name or user name you may use. If we learn we
                            have collected or received personal information from a person under 18, we will delete that
                            information. If you believe we might have any information from or about a person under 18,
                            please contact us at [APPROPRIATE JANE VERDE EMAIL ADDRESS].
                        </p>
                        <h3>Information We Collect About Your and Howe We Collect It</h3>
                        <p>We collect several types of information from and about uses of our Website, including
                            information:</p>
                        <ul>
                            <li>By which you may be personally identified, such as name, postal address, e-mail address,
                                telephone number, or any other identifier by which you may be contacted online or
                                offline (“personal information”);
                            </li>
                            <li>
                                That is about you but individually does not identify you; and/or
                            </li>
                            <li>
                                About your internet connection, the equipment you use to access our Website, and usage
                                details.
                            </li>
                        </ul>
                        <p>We collect this information:</p>
                        <ul>
                            <li>Directly from you when you provide it to us.</li>
                            <li>Automatically as you navigate through the site. Information collected automatically may
                                include usage details, IP addresses, and information collected through cookies and other
                                tracking technologies.
                            </li>
                            <li>From third parties, for example, our business partners</li>
                        </ul>
                        <h2>INFORMATION YOU PROVIDE TO US</h2>
                        <p>The information we collect on or through our Website may include:</p>
                        <ul>
                            <li>Information that you provide by filling in forms on our Website. This includes
                                information provided at the time of registering to use our Website, subscribing to our
                                services, posting material, or requesting further services. We may also ask you for
                                information when you enter a contest or promotion sponsored by us, and when you report a
                                problem with our Website.
                            </li>
                            <li>Records and copies of your correspondence (including email addresses), if you contact
                                us.</li>
                            <li>Your responses to surveys that we might ask you to complete for research purposes.</li>
                            <li>Details of transactions you carry out through our Website and of the fulfillment of your
                                orders. You may be required to provide financial information before placing an order
                                through our Website.
                            </li>
                            <li>Your search queries on the Website.</li>
                        </ul>
                        <p>You also may provide information to be published or displayed (hereinafter, “posted”) on
                            public areas of the Website, or transmitted to other users of the Website or third parties
                            (collectively, “User Contributions”). Your User Contributions are posted on and transmitted
                            to others at your own risk. Although we limit access to certain pages, please be aware that
                            no security measures are perfect or impenetrable. Additionally, we cannot control the
                            actions of other users of the Website with whom you may choose to share your User
                            Contributions. Therefore, we cannot and do not guarantee that your User Contributions will
                            not be viewed by unauthorized persons.
                        </p>
                        <h2>INFORMATION WE COLLECT THROUGH AUTOMATIC DATA COLLECTION TECHNOLOGIES</h2>
                        <p>As you navigate through and interact with our Website, we may use automatic data collection
                            technologies to collect certain information about your equipment, browsing actions, and
                            patterns, including:
                        </p>
                        <ul>
                            <li>Details of your visits to our Website, including traffic data, location data, logs, and
                                other communication data and the resources that you access and use on the Website.
                            </li>
                            <li>
                                Information about your computer and internet connection, including your IP address,
                                operating system, and browser type.
                            </li>
                            <li>
                                We also may use these technologies to collect information about your online activities
                                over time and across third-party websites or other online services (behavioral
                                tracking). It helps us to improve our Website and to deliver a better and more
                                personalized service, including by enabling us to:
                            </li>
                            <li>
                                Estimate our audience size and usage patterns
                            </li>
                            <li>Store information about your preferences, allowing us to customize our Website according
                                to your individual interests.</li>
                            <li>Speed up your searches.</li>
                            <li>Recognize you when you return to our Website.</li>
                        </ul>
                        <p>The technologies we use for this automatic data collection may include:</p>
                        <p><b>Cookies (or browser cookies).</b> A cookie is a small file placed on the hard drive of
                            your
                            computer. You may refuse to accept browser cookies by activating the appropriate setting on
                            your browser. However, if you select this setting you may be unable to access certain parts
                            of our Website. Unless you have adjusted your browser setting so that it will refuse
                            cookies, our system will issue cookies when you direct your browser to our Website.
                        </p>
                        <p><b>Flash Cookies.</b> Certain features of our Website may use local stored objects (or Flash
                            cookies) to collect and store information about your preferences and navigation to, from,
                            and on our Website. Flash cookies are not managed by the same browser settings as are used
                            for browser cookies. Please contact us for more information about managing your privacy and
                            security settings for Flash cookies.
                        </p>
                        <h3>How We Use Your Information</h3>
                        <p>We use information that we collect about you or that you provide to us, including any
                            personal information:</p>
                        <ul>
                            <li>To present our Website and its contents to you.</li>
                            <li>To provide you with information, products, or services that you request from us.</li>
                            <li>To fulfill any other purpose for which you provide it.</li>
                            <li>To provide you with notices about your account and/or subscription, including expiration
                                and renewal notices.</li>
                            <li>To carry out our obligations and enforce our rights arising from any contracts entered
                                into between you and us, including for billing and collection.</li>
                            <li>To notify you about changes to our Website or any products or services we offer or
                                provide through it.</li>
                            <li>To allow you to participate in interactive features on our Website.</li>
                            <li>In any other way we may describe when you provide the information.</li>
                            <li>For any other purpose with your consent.</li>
                        </ul>
                        <h3>Disclosure of Your Information</h3>
                        <p>We may disclose aggregated information about our users without restriction.</p>
                        <p>We may disclose personal information that we collect or you provide as described in this
                            privacy policy:</p>
                        <ul>
                            <li>To our subsidiaries and affiliates.</li>
                            <li>To contractors, service providers, and other third parties we use to support our
                                business</li>
                            <li>To a buyer or other successor in the event of a merger, divestiture, restructuring,
                                reorganization, dissolution, or other sale or transfer of some or all of Jane Verde’s
                                assets, whether as a going concern or as part of bankruptcy, liquidation, or similar
                                proceeding, in which personal information held by Jane Verde about our Website users is
                                among the assets transferred.</li>
                            <li>For any other purpose disclosed by us when you provide the information.</li>
                            <li>With your consent.</li>
                        </ul>
                        <p>We may also disclose your personal information:</p>
                        <ul>
                            <li>To comply with any court order, law, or legal process, including to respond to any
                                government or regulatory request.</li>
                            <li>To enforce or apply our terms of use [LINK TO TERMS OF USE] and other agreements,
                                including for billing and collection purposes.</li>
                            <li>If we believe disclosure is necessary or appropriate to protect the rights, property, or
                                safety of Jane Verde, our customers, or others.</li>
                        </ul>
                        <h3>Choices About Howe We Use and Disclose Your Information</h3>
                        <p>We strive to provide you with choices regarding the personal information you provide to us.
                            We have created mechanisms to provide you with the following control over your information:
                        </p>
                        <p><b>Tracking Technologies and Advertising.</b> You can set your browser to refuse all or some
                            browser
                            cookies, or to alert you when cookie are being sent. To learn how you can mange your Flash
                            cookie settings, visit the Flash player settings page on Adobe’s website. If you disable or
                            refuse cookies, please note that some parts of this site may then be inaccessible or not
                            function properly.
                        </p>
                        <p>We do not control third parties’ collection or use of your information to serve
                            interest-based advertising. However, these third parties may provide you with ways to choose
                            not to have your information collected or used in this way. You can opt out of receiving
                            targeted ads from members of the Network Advertising Initiative (“NAI”) on the NAI’s
                            website.
                        </p>
                        <h3>Data Security</h3>
                        <p>We have implemented measures designed to secure your personal information from accidental
                            loss and from unauthorized access, use, alteration, and disclosure. All information you
                            provide to us is stored on our secure servers behind firewalls. Any payment transactions
                            will be encrypted using SSL technology. The safety and security of your information also
                            depends on you. Where we have given you (or where you have chosen) a password for access to
                            certain parts of our Website, you are responsible for keeping this password confidential. We
                            ask you not to share your password with anyone. Unfortunately, the transmission of
                            information via the internet is not completely secure. Although we do our best to protect
                            your personal information, we cannot guarantee the security of your personal information
                            transmitted to our Website. Any transmission of personal information is at your own risk. We
                            are not responsible for circumvention of any privacy settings or security measures contained
                            on the Website.
                        </p>
                        <h3>Changes to Our Privacy Policy</h3>
                        <p>It is our policy to post any changes we make to our privacy policy on this page. If we make
                            material changes to how we treat our users’ personal information, we will notify you through
                            a notice on the Website home page. The date the privacy policy was last revised is
                            identified at the top of the page. You are responsible for ensuring we have an
                            up-to-date active and deliverable email address for you, and for periodically visiting our
                            Website and this privacy policy to check for any changes.
                        </p>
                        <h3>Contact Information</h3>
                        <p>To ask questions or comment about this privacy policy and our privacy practices, contact us at:</p>
                        <a href="mailto:contact@janeverde.com">contact@janeverde.com</a>
                    </div>
                </div>
            </div>
        </div>
        @include("partials.footer")
    </div>
</div>
</div>

@section("js_links")
<script type="text/javascript" src={{asset('js/libraries/jquery.js')}}></script>
<script type="text/javascript" src={{asset('js/libraries/selectric.js')}}></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
<script type="text/javascript" src={{asset('js/main.js')}}></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="http://www.googletagmanager.com/gtag/js?id=UA-148323450-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-148323450-1');
</script>

@endsection

@endsection