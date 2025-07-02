<footer class="app-footer">
    <div class="site-footer-right">
        {!! __('voyager::theme.footer_copyright') !!} <a href="https://dodel.co?utm_source=gingersauce.system" target="_blank">dodel</a>
        @php $version = Voyager::getVersion(); @endphp
        @if (!empty($version))
            - {{ $version }}
        @endif
    </div>
</footer>
