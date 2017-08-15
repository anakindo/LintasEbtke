<div id="app_sipeda">
	<div class="bg__gray">
		<div class="page-title">
			<div class="title_left">
		        <h3>INVESTASI PLTS ROOFTOP</h3>
		        <p>SIPEDIA MANAGEMENT SYSTEM</p>
		    </div>
		</div>
	</div>
    <div v-if="showModal == true" class="popup__mask__alert">
        <div class="popup__wrapper__alert">
            <div class="popup__layer__alert">
                <div class="alert__message__wrapper">
                    <div class="alert__message">
                        <img src="{{ asset('themes/ebtke/sipeda/images/logo-alert.png') }}" alt="">
                        <h3>Alert!</h3>
                        <label>Are you sure that you want to delete this?</label>
                    </div>
                    <div class="alert__message__btn">
                        <div class="new__form__btn">
                            <a href="#" class="btn__form__reset" @click.prevent="closeDeleteModal">Cancel</a>
                            <a href="#" class="btn__form__create" @click="deleteData(delete_payload.id)">Confirm</a>
                        </div>
                    </div>
                    <button class="alert__message__close" @click.prevent="closeDeleteModal"></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 col-sm-12 col-xs-12">
    	<!-- Include form -->
    	@include('ebtke.sipeda.pages.investasi-plts-rooftop.partials.form')
    	<!-- / End include form -->
		<div class="main__content__layer">
			<div class="content__top flex-between">
				<div class="content__title">
					<h2>@{{ form_add_title }}</h2>
				</div>
				<div class="content__btn">
					<a href="#" class="btn__add" id="toggle-form">Add Data</a>
		       	</div>
		    </div>
		    
		    <div class="content__bottom">
                <table class="table__style" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Nama Pemilik</th>
                            <th>Sumber Dana</th>
                            <th>Lokasi</th>
                            <th>Koordinat</th>
                            <th>Kapasitas PLTS Rooftop <b>(kW)</b></th>
                            <th>Tahun Investasi</th>
                            <th><center>Rencana Pengembangan</center></th>
                            <th>Rencana Investasi <br/><i>(Capex + Opex)</i></th>
                            <th>Realisasi Investasi <br/><i>(Capex + Opex)</i></th>
                        </tr>
                        <tr v-for="(investasi_plts, index) in responseData.investasi_plts">
                            <td>@{{ index+1 }}</td>
                            <td>@{{ investasi_plts.nama_pemilik }}</td>
                            <td>@{{ investasi_plts.sumber_dana }}</td>
                            <td>
                                <b>Provinsi : </b> @{{ investasi_plts.provinsi }}<br/>
                                <b>Kabupaten : </b> @{{ investasi_plts.kabupaten }}
                            </td>
                            <td>
                                <b>Latitude : </b> @{{ investasi_plts.latitude }}<br/>
                                <b>Longitude : </b> @{{ investasi_plts.longitude }}
                            </td>
                            <td>
                                @{{ investasi_plts.kapasitas_plts }}
                                <b>kW</b>
                            </td>
                            <td>@{{ investasi_plts.tahun_investasi }}</td>
                            <td>
                                <b>Penambahan Kapasitas : </b>@{{ investasi_plts.penambahan_kapasitas }},<br/> 
                                <b>Penambahan Komponen : </b>@{{ investasi_plts.penambahan_komponen }}, <br/>
                                <b>Peningkatan Efisiensi : </b>@{{ investasi_plts.peningkatan_efisiensi }}
                            </td>
                            <td>@{{ investasi_plts.rencana_investasi }}</td>
                            <td>@{{ investasi_plts.realisasi_investasi }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

		</div>

    </div>
</div>