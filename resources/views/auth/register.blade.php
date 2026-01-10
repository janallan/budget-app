@section('title', 'Register')

<x-layouts.guest>
    <div class="flex min-h-screen">
        <div class="flex-1 flex justify-center items-center">
            <div class="w-80 max-w-80 space-y-6">
                <div class="flex justify-center opacity-50">
                    <a href="/" class="group flex items-center gap-3">
                        <div>
                            <svg class="h-4 text-zinc-800 dark:text-white" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <line x1="1" y1="5" x2="1" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                                    <line x1="5" y1="1" x2="5" y2="8" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                                    <line x1="9" y1="5" x2="9" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                                    <line x1="13" y1="1" x2="13" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                                    <line x1="17" y1="5" x2="17" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                                </g>
                            </svg>
                        </div>

                        <span class="text-xl font-semibold text-zinc-800 dark:text-white">flux</span>
                    </a>
                </div>

                <flux:heading class="text-center" size="xl">Register</flux:heading>

                <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
                    @csrf
                    <flux:input label="First Name" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" />
                    <flux:input label="Last Name" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" />

                    <flux:input label="Email" type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" />
                    <flux:input label="Password" type="password" name="password" placeholder="Your password" />
                    <flux:input label="Confirm Password" type="password" name="password_confirmation" placeholder="Confirm password" />

                    <flux:button type="submit" variant="primary" class="w-full">Register</flux:button>
                </form>

                <flux:subheading class="text-center">
                    Already registered? <flux:link href="{{ route('login') }}">Sign in</flux:link>
                </flux:subheading>
            </div>
        </div>

        <div class="flex-1 p-4 max-lg:hidden">
            <div class="text-white relative rounded-lg h-full w-full bg-zinc-900 flex flex-col items-start justify-end p-16" style="background-image: url('https://fluxui.dev/img/demo/auth_aurora_2x.png'); background-size: cover">
                <div class="flex gap-2 mb-4">
                    <flux:icon.star variant="solid" />
                    <flux:icon.star variant="solid" />
                    <flux:icon.star variant="solid" />
                    <flux:icon.star variant="solid" />
                    <flux:icon.star variant="solid" />
                </div>

                <div class="mb-6 italic font-base text-3xl xl:text-4xl">
                    Flux has enabled me to design, build, and deliver apps faster than ever before.
                </div>

                <div class="flex gap-4">
                    <flux:avatar src="https://fluxui.dev/img/demo/caleb.png" size="xl" />

                    <div class="flex flex-col justify-center font-medium">
                        <div class="text-lg">Caleb Porzio</div>
                        <div class="text-zinc-300">Creator of Livewire</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
