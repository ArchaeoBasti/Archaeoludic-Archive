<x-app-layout>
    <!-- Header -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                Imprint
            </h1>
        </div>
    </div>

    <!-- Gelber Streifen -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[#313647]">Legal disclosure according to § 5 TMG</p>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <section class="mb-8">
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">Responsible for content</h2>
                        <p class="text-[#435663]">
                            Sebastian Hageneuer<br>
                            <!-- Adresse hier einfügen -->
                            Berlin, Germany
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">Contact</h2>
                        <p class="text-[#435663]">
                            Email: <span id="email-address"></span>
                            <noscript>[JavaScript required to display email]</noscript>
                        </p>
                        <script>
                            var u = 's.hageneuer';
                            var d = 'outlook.de';
                            var e = document.getElementById('email-address');
                            e.innerHTML = '<a href="mailto:' + u + '@' + d + '" class="text-[#435663] hover:text-[#A3B087] underline">' + u + '@' + d + '</a>';
                        </script>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">Liability for content</h2>
                        <p class="text-[#435663] mb-4">
                            The contents of this website have been created with the utmost care. However, I cannot guarantee the accuracy, completeness, or timeliness of the content. As a service provider, I am responsible for my own content on these pages according to § 7 para. 1 TMG. According to §§ 8 to 10 TMG, however, I am not obligated as a service provider to monitor transmitted or stored third-party information or to investigate circumstances that indicate illegal activity.
                        </p>
                        <p class="text-[#435663]">
                            Obligations to remove or block the use of information under general law remain unaffected. However, liability in this regard is only possible from the time of knowledge of a specific infringement. Upon becoming aware of corresponding infringements, I will remove this content immediately.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">Liability for links</h2>
                        <p class="text-[#435663]">
                            This website contains links to external websites of third parties over whose content I have no influence. Therefore, I cannot assume any liability for these external contents. The respective provider or operator of the pages is always responsible for the contents of the linked pages. The linked pages were checked for possible legal violations at the time of linking. Illegal contents were not recognizable at the time of linking. However, permanent monitoring of the content of the linked pages is not reasonable without concrete evidence of an infringement. Upon becoming aware of legal violations, I will remove such links immediately.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">Copyright</h2>
                        <p class="text-[#435663] mb-4">
                            The source code of this website is available under the MIT License on <a href="https://github.com/ArchaeoBasti/Archaeoludic-Archive" target="_blank" class="text-[#435663] hover:text-[#A3B087] underline">GitHub</a>.
                        </p>
                        <p class="text-[#435663]">
                            The database content (game entries, metadata, and curated information) is made available for academic and research purposes. Game cover images and descriptions are sourced from IGDB and remain the property of their respective owners.
                        </p>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
