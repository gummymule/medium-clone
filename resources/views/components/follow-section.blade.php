@props(['user'])

<div {{ $attributes }} x-data="{ 
    isFollowing: @json($user->isFollowedBy(auth()->user())),
    followersCount: @json($user->followers->count()),
    follow() {
        axios.post('/follow/{{ $user->id }}')
        .then(res => {
                console.log(res.data)
                this.isFollowing = !this.isFollowing
                this.followersCount = res.data.followersCount
            })
            .catch(err => {
                console.log(err)
            })
    } 
} " 
class="w-[320px] border-l px-8">
    {{ $slot }}
</div>