@if (Session::get('alert-class') == 'alert-success')
    <span class="alert-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999"
                stroke="#6DAE43" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M22 4L12 14.01L9 11.01" stroke="#6DAE43" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </span>
@elseif(Session::get('alert-class') == 'alert-info')
    <span class="alert-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                stroke="#0091EA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M12 16V12" stroke="#0091EA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M12 8H12.01" stroke="#0091EA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </span>
@elseif(Session::get('alert-class') == 'alert-warning')
    <span class="alert-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M1.82002 18L10.29 3.85996C10.4683 3.56607 10.7193 3.32308 11.0188 3.15444C11.3184 2.98581 11.6563 2.89722 12 2.89722C12.3438 2.89722 12.6817 2.98581 12.9812 3.15444C13.2807 3.32308 13.5318 3.56607 13.71 3.85996L22.18 18C22.3547 18.3024 22.4471 18.6453 22.448 18.9945C22.449 19.3437 22.3585 19.6871 22.1856 19.9905C22.0127 20.2939 21.7633 20.5467 21.4623 20.7238C21.1613 20.9009 20.8192 20.9961 20.47 21H3.53002C3.18082 20.9961 2.83871 20.9009 2.53773 20.7238C2.23675 20.5467 1.98738 20.2939 1.81445 19.9905C1.64151 19.6871 1.55103 19.3437 1.55201 18.9945C1.55299 18.6453 1.64539 18.3024 1.82002 18Z"
                stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M12 9V13" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M12 17H12.01" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </span>
@elseif(Session::get('alert-class') == 'alert-danger')
    <span class="alert-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z"
                stroke="#F4511E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M9 9L15 15" stroke="#F4511E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M15 9L9 15" stroke="#F4511E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </span>
@endif
