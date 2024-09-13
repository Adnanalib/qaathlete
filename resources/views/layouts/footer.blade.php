@auth
    <footer class="footer-logo-container desktop">
        <div class="flex pt-3">
            <img src="{{ asset('assets/images/footer-log-black-white.png') }}" alt="" class="footer-logo"
                class="cursor-pointer" onclick="window.location.href='{{ route('welcome') }}'" />
            <span class="footer-item" onclick="window.location.href='https://quickcaptureathletics.com/partnership/'">Partnerships & Inquires</span>
            <span class="footer-item" onclick="window.location.href='https://quickcaptureathletics.com/contact-us/'">Contact Us</span>
            <span class="footer-item" onclick="window.location.href='{{getCurrentUserHomeUrl()}}'">Home</span>
        </div>
        <div class="hr-line"></div>
        <div class="flex mt-3">
            <span class="pl-0 footer-item no-link">© copyrights 2022</span>
            <span class="footer-item" onclick="window.location.href='https://quickcaptureathletics.com/terms-and-conditions/'">Terms and Conditions</span>
            <span class="footer-item" onclick="window.location.href='https://quickcaptureathletics.com/privacy-policy/'">Privacy Policy</span>
        </div>
    </footer>
    <footer class="footer-logo-container mobile">
        <div class="pt-3 text-center">
            <img src="{{ asset('assets/images/footer-log-black-white.png') }}" alt="" class="footer-logo"
                class="cursor-pointer" onclick="window.location.href='{{ route('welcome') }}'" />
            <span class="footer-item" onclick="window.location.href='https://quickcaptureathletics.com/partnerships-and-inquries/'">Partnerships & Inquires</span>
            <span class="footer-item" onclick="window.location.href='https://quickcaptureathletics.com/contact-us/'">Contact Us</span>
            <span class="footer-item" onclick="window.location.href='{{getCurrentUserHomeUrl()}}'">Home</span>
        </div>
        <div class="hr-line"></div>
        <div class="mt-3 text-center">
            <span class="pl-0 footer-item no-link">© copyrights 2022</span>
            <span class="footer-item" onclick="window.location.href='https://quickcaptureathletics.com/terms-and-conditions/'">Terms and Conditions</span>
            <span class="footer-item" onclick="window.location.href='https://quickcaptureathletics.com/privacy-policy/'">Privacy Policy</span>
        </div>
    </footer>
@endauth
@guest
    <footer class="footer-logo-container mobile profile-view">
        <div class="flex pt-3">
            <span class="footer-item join-text">Join QuickCaptureatheletics.com</span>
            <span class="footer-item">
                <a href="{{url('/register')}}" class="btn btn-primary signup-profile-view">SignUp</a>
            </span>
        </div>
    </footer>
@endguest
