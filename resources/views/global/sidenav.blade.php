
<flux:sidebar.nav>
    <flux:sidebar.item icon="home" :href="route('home')" :current="request()->is('/')">Home</flux:sidebar.item>
    <flux:sidebar.item icon="document" :href="route('transactions.index')" :current="request()->is('transactions.*')">Transaction</flux:sidebar.item>
    <flux:sidebar.group expandable icon="list-bullet"  heading="Libraries" class="grid">
        <flux:sidebar.item :href="route('categories.index')" :current="request()->is('categories*')">Categories</flux:sidebar.item>
    </flux:sidebar.group>
    <flux:sidebar.item icon="cog-6-tooth" :href="route('settings.index')" :current="request()->is('settings*')">Settings</flux:sidebar.item>
</flux:sidebar.nav>
