<ul class="nav navbar-nav">
	<?
	$pages = PagesManager::instance()->get()->where('in_menu', true)->where('parent', 'home'); ?>
	@foreach ($pages as $page)

		<?php $children = PagesManager::instance()->getChildren($page)->where('in_menu', true) ?>
		<?php $childrenExist = (bool) $children->count() ?>

		<li{!! $childrenExist ? ' class="dropdown"' : '' !!}>

			<a
				@if ($childrenExist)
				class="dropdown-toggle"
				data-toggle="dropdown"
				role="button"
				aria-haspopup="true"
				aria-expanded="false"
				@endif
				href="{{ $page->getUri() }}">
				{{$page->getTitle()}}
				@if ($childrenExist)
					<span class="caret"></span>
				@endif
			</a>
			@if ($childrenExist)
				<ul class="dropdown-menu">
					@if(data_get($page, 'uses'))
						<li>
							<a href="/{{$page->getUri()}}">{{$page->getTitle()}}</a>
						</li>
					@endif

					@foreach($children as $child)
						<li>
							<a href="/{{$child->getUri()}}">{{$child->getTitle()}}</a>
						</li>
					@endforeach
				</ul>
			@endif
		</li>

	@endforeach
</ul>