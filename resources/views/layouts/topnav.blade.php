<div class="relative bg-white mt-px">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-row justify-center items-center border-b-2 border-gray-100 py-2 md:space-x-10">
            <nav class="hidden md:flex space-x-10">
                <a href="/home"
                   class="text-base leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline @if(isset($activeLink) && $activeLink=='home') text-blue-400 rounded font-semibold hover:text-blue-600 @else text-gray-600 hover:text-gray-900 focus:text-gray-900 @endif">
                    Home
                </a>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-item  text-base leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline @if(isset($activeLink) && $activeLink=='products') text-blue-400 rounded font-semibold hover:text-blue-600 @else text-gray-600 hover:text-gray-900 focus:text-gray-900 @endif"
                       href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Products
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item flex flex-row align-items-center" href="/products">
{{--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 mr-2 text-info">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />--}}
{{--                            </svg>--}}
                            <span class="text-base">Product Lists</span>
                        </a>
                        <a class="dropdown-item flex flex-row  text-base" href="/product-categories">Product Categories</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-item  text-base leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline @if(isset($activeLink) && $activeLink=='business') text-blue-400 rounded font-semibold hover:text-blue-600 @else text-gray-600 hover:text-gray-900 focus:text-gray-900 @endif"
                       href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Business
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item flex flex-row  text-base" href="/quotations">Quotations</a>
                        <a class="dropdown-item flex flex-row  text-base" href="/orders">Orders</a>
                        <h6 class="dropdown-header">E-commerce</h6>
{{--                        <a class="dropdown-item flex flex-row  text-base" href="/marketplace">Marketplace</a>--}}
                        <a class="dropdown-item flex flex-row  text-base" href="/promo-codes">Promo Codes</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-item  text-base leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline @if(isset($activeLink) && $activeLink=='accounting') text-blue-400 rounded font-semibold hover:text-blue-600 @else text-gray-600 hover:text-gray-900 focus:text-gray-900 @endif"
                       href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Accounting
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item flex flex-row  text-base" href="/invoices">Invoices</a>
{{--                        <h6 class="dropdown-header">Dropdown header</h6>--}}
{{--                        <a class="dropdown-item flex flex-row  text-base" href="/expenses">Expenses</a>--}}
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-item  text-base leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline @if(isset($activeLink) && $activeLink=='contacts') text-blue-400 rounded font-semibold hover:text-blue-600 @else text-gray-600 hover:text-gray-900 focus:text-gray-900 @endif"
                       href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Contacts
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item flex flex-row text-base" href="/clients">Clients</a>
                        <a class="dropdown-item flex flex-row text-base" href="/suppliers">Suppliers</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-item  text-base leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline @if(isset($activeLink) && $activeLink=='contacts') text-blue-400 rounded font-semibold hover:text-blue-600 @else text-gray-600 hover:text-gray-900 focus:text-gray-900 @endif"
                       href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Team
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item flex flex-row text-base" href="/team-members">Team Members</a>
{{--                        <a class="dropdown-item flex flex-row text-base" href="/leave-management">Leave Management</a>--}}
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
