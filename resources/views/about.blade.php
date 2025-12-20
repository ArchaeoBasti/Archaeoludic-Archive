<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    About
                </h1>
            </div>
        </div>
    </div>

    <!-- Gelber Streifen -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-[#313647]">
                <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">About the project and its creator</span>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- The Project -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200 mb-8">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold text-[#313647] mb-6 border-b border-[#A3B087] pb-2">The Project</h2>

                    <div class="prose max-w-none text-[#435663]">
                        <p class="mb-4">
                            The Archaeoludic Archive is a curated database documenting video games that engage with archaeology, cultural heritage, and the ancient past. From iconic adventurers like Lara Croft to strategy games set in ancient civilizations, these games shape how millions of players perceive and interact with history.
                        </p>

                        <p class="mb-4">
                            The primary goal of this project is to create a comprehensive database of archaeogames that is backed by scholarly literature. This means that users can not only find information about a game itself, but more importantly discover academic references that examine the game from an archaeogaming perspective – analyzing historical representations, gameplay mechanics, cultural impact, and more.
                        </p>

                        <p class="mb-4">
                            Each entry is enriched with linked open data connections to Wikidata, IGDB, Steam, and GOG, ensuring interoperability with other digital humanities projects. Scholarly references are managed through Zotero, linking games directly to academic literature. By applying a controlled vocabulary for archaeological and historical content, the archive enables systematic analysis of player roles, time periods, and cultural contexts across the gaming landscape.
                        </p>

                        <p class="mb-4">
                            Currently, this is a private project and serves as a proof of concept. The vision is to expand it into a larger research project in the future, potentially in collaboration with academic institutions. This resource is intended to serve researchers studying digital heritage, educators seeking to incorporate games into teaching, and anyone interested in how interactive media represent and interpret the past.
                        </p>
                    </div>
                </div>
            </div>

            <!-- About Me -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold text-[#313647] mb-6 border-b border-[#A3B087] pb-2">About Me</h2>

                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Photo -->
                        <div class="flex-shrink-0">
                            <img src="https://i0.wp.com/itsmoreofacomment.com/wp-content/uploads/2025/08/Sebastian-edited.jpg?resize=300%2C300&ssl=1"
                                 alt="Sebastian Hageneuer"
                                 class="w-64 h-64 object-cover rounded-lg shadow-lg">
                        </div>

                        <!-- Bio -->
                        <div class="flex-grow">
                            <h3 class="text-xl font-semibold text-[#313647] mb-4">Sebastian Hageneuer</h3>

                            <div class="prose max-w-none text-[#435663]">
                                <p class="mb-4">
                                    I'm an archaeologist working at the crossroads of Digital Archaeology, data infrastructures, and West Asian Archaeology. I studied the Archaeology of West Asia at Freie Universität Berlin, where I also completed my PhD on historical reconstructions and their role in shaping our view of antiquity in comparison to modern-day video games.
                                </p>

                                <p class="mb-4">
                                    After several years as a research assistant at the University of Cologne, I am now a work group leader of the project KIŠIB — the Digital Corpus of Ancient West Asian Seals and Sealings — at the Berlin-Brandenburg Academy of Sciences and Humanities.
                                </p>

                                <p class="mb-4">
                                    Beyond seals and databases, I enjoy teaching digital methods, writing about the intersections of archaeology and technology, and experimenting with archaeogaming and playful approaches to heritage. Archaeogaming, for me, is the research of the presentation of history, archaeology and archaeologists within video games. These games have a huge influence on younger generations and often use colonial tropes or problematic imagery – but some games are very good at showing what archaeologists actually do.
                                </p>

                                <p class="mb-4">
                                    I'm also a board member of the <a href="https://value-foundation.org/" target="_blank" class="text-blue-600 hover:underline">VALUE Foundation</a> and co-coordinator of the project <a href="https://dikopa.net/" target="_blank" class="text-blue-600 hover:underline">"Digitale Kompetenzen in der Archäologie" (DiKopA)</a>.
                                </p>
                            </div>

                            <!-- Links -->
                            <div class="mt-6 flex flex-wrap gap-4">
                                <a href="https://itsmoreofacomment.com/" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-[#313647] text-white rounded-lg hover:bg-[#435663] transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    Blog
                                </a>
                                <a href="https://orcid.org/0000-0001-8973-1544" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-[#A3B087] text-[#313647] rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                    <img src="https://orcid.org/sites/default/files/images/orcid_16x16.png" alt="ORCID" class="w-4 h-4">
                                    ORCID
                                </a>
                                <a href="https://www.researchgate.net/profile/Sebastian-Hageneuer" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-[#A3B087] text-[#313647] rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.586 0c-.818 0-1.508.19-2.073.565-.563.377-.97.936-1.213 1.68a3.193 3.193 0 0 0-.112.437 8.365 8.365 0 0 0-.078.53 9 9 0 0 0-.05.727c-.01.282-.013.621-.013 1.016a31.121 31.121 0 0 0 .014 1.017 9 9 0 0 0 .05.727 7.946 7.946 0 0 0 .078.53h-.005a3.334 3.334 0 0 0 .112.438c.244.743.65 1.303 1.214 1.68.565.376 1.256.564 2.075.564.8 0 1.536-.213 2.105-.603.57-.39.94-.916 1.175-1.65.076-.235.135-.558.177-.93a10.9 10.9 0 0 0 .043-1.207v-.82c0-.095-.047-.142-.14-.142h-3.064c-.094 0-.14.047-.14.141v.956c0 .094.046.14.14.14h1.666c.056 0 .084.03.084.086 0 .36 0 .62-.036.865-.038.244-.1.447-.147.606-.108.385-.348.664-.638.876-.29.212-.738.35-1.227.35-.545 0-.901-.15-1.21-.353-.306-.203-.517-.454-.67-.915a3.136 3.136 0 0 1-.147-.762 17.366 17.366 0 0 1-.034-.656c-.01-.26-.014-.572-.014-.939a26.401 26.401 0 0 1 .014-.938 15.821 15.821 0 0 1 .035-.656 3.19 3.19 0 0 1 .148-.76c.152-.46.363-.712.67-.916.31-.203.665-.353 1.21-.353.51 0 .912.142 1.19.37.278.23.47.503.596.96.023.094.07.141.165.141h1.142c.094 0 .14-.047.14-.14-.04-.356-.112-.678-.209-.964-.096-.286-.24-.57-.432-.852-.191-.282-.435-.514-.73-.696a3.963 3.963 0 0 0-1.073-.454A5.087 5.087 0 0 0 19.586 0zM5.306 5.168c-.094 0-.14.047-.14.14v8.09c0 .095.046.142.14.142h1.273c.093 0 .14-.047.14-.14v-2.835c0-.093.046-.14.14-.14h2.076l1.65 2.975c.02.04.05.074.093.1.042.026.092.04.149.04h1.273c.112 0 .168-.066.168-.14a.233.233 0 0 0-.028-.103l-1.65-2.932c-.02-.047-.02-.094 0-.14.396-.205.737-.471.953-.857.217-.387.325-.835.325-1.345 0-.565-.118-1.04-.354-1.422-.236-.38-.57-.67-1.003-.863-.433-.195-.94-.292-1.52-.292H5.305zm1.413 1.133h2.04c.375 0 .67.088.886.264.216.176.324.456.324.838 0 .375-.108.664-.324.858-.217.193-.51.29-.886.29H6.72c-.094 0-.14-.046-.14-.14v-1.97c0-.093.046-.14.14-.14z"/>
                                    </svg>
                                    ResearchGate
                                </a>
                                <a href="https://github.com/archaeobasti" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-[#A3B087] text-[#313647] rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                    GitHub
                                </a>
                                <a href="https://www.linkedin.com/in/sebastian-hageneuer/" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-[#A3B087] text-[#313647] rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                    LinkedIn
                                </a>
                                <a href="https://mastodon.online/@ArchaeoBasti" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-[#A3B087] text-[#313647] rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.268 5.313c-.35-2.578-2.617-4.61-5.304-5.004C17.51.242 15.792 0 11.813 0h-.03c-3.98 0-4.835.242-5.288.309C3.882.692 1.496 2.518.917 5.127.64 6.412.61 7.837.661 9.143c.074 1.874.088 3.745.26 5.611.118 1.24.325 2.47.62 3.68.55 2.237 2.777 4.098 4.96 4.857 2.336.792 4.849.923 7.256.38.265-.061.527-.132.786-.213.585-.184 1.27-.39 1.774-.753a.057.057 0 0 0 .023-.043v-1.809a.052.052 0 0 0-.02-.041.053.053 0 0 0-.046-.01 20.282 20.282 0 0 1-4.709.545c-2.73 0-3.463-1.284-3.674-1.818a5.593 5.593 0 0 1-.319-1.433.053.053 0 0 1 .066-.054c1.517.363 3.072.546 4.632.546.376 0 .75 0 1.125-.01 1.57-.044 3.224-.124 4.768-.422.038-.008.077-.015.11-.024 2.435-.464 4.753-1.92 4.989-5.604.008-.145.03-1.52.03-1.67.002-.512.167-3.63-.024-5.545zm-3.748 9.195h-2.561V8.29c0-1.309-.55-1.976-1.67-1.976-1.23 0-1.846.79-1.846 2.35v3.403h-2.546V8.663c0-1.56-.617-2.35-1.848-2.35-1.112 0-1.668.668-1.668 1.977v6.218H4.822V8.102c0-1.31.337-2.35 1.011-3.12.696-.77 1.608-1.164 2.74-1.164 1.311 0 2.302.5 2.962 1.498l.638 1.06.638-1.06c.66-.999 1.65-1.498 2.96-1.498 1.13 0 2.043.395 2.74 1.164.675.77 1.012 1.81 1.012 3.12z"/>
                                    </svg>
                                    Mastodon
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
