                    <x-nav-link :href="route('games.index')" :active="request()->routeIs('games.*')">
                        {{ __('Games') }}
                    </x-nav-link>
                    <x-nav-link :href="route('animeaux.index')" :active="request()->routeIs('animeaux.*')">
                        {{ __('Animaux') }}
                    </x-nav-link> 