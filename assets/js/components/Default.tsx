import React, {Component, SyntheticEvent, ChangeEvent} from 'react';
import axios from 'axios';

import { DefaultInterface } from '../interfaces/DefaultInterface';
import { PDV } from '../interfaces/pdv';
import { PDV_PRICE } from '../interfaces/pdv_prices';


class Default extends Component {

    constructor(props: DefaultInterface) {
        super(props);

        this.state = {
            city: '',
            pdvs: [],
        }

        this.handleChangeCity = this.handleChangeCity.bind(this);
        this.submitSearchPdv = this.submitSearchPdv.bind(this);
        
    }
    
    
    componentDidMount() {
        // rechercher s'il y a un id pour l'update
    }
    
    
    handleChangeCity(event: ChangeEvent<HTMLInputElement>) {   
        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;
    
        this.setState({
            [name]: value
        });
    }

    async handleOpenPdv(city: {
        context: string
    }) {
        
        const results = await axios.post('/api/pdvs', {context: city.context})
        .then(function(response) {
            return response;
        });

        this.setState({
            
        });

        console.log(results)
    }
    

    async submitSearchPdv(event: SyntheticEvent) {
        event.preventDefault();

        const results = await axios.get('/api/search-pdv/' + this.state.city).then(function(response) {
            return response;
        });
        
        this.setState({
            pdvs: results.data
        });
    }

    render() {
        const pdvs = this.state.pdvs

        return (
            <>
                <form action="" 
                    className='row wrap-top'
                    onSubmit={this.submitSearchPdv}
                >
                    <div className="col-md-8">
                        <input 
                            type="text" 
                            name="city"
                            className="form-control" 
                            placeholder='Votre ville' 
                            value={this.state.city}
                            onChange={this.handleChangeCity}
                        />
                    </div>
                    <div className="col-md-2">
                        <select name="" id="" className="form-control">
                            <option value="0">0 km</option>
                            <option value="10">10 km</option>
                        </select>
                    </div>
                    <div className="col-md-2">
                        <button className='btn btn-secondary'>Valider</button>
                    </div>
                </form>
                <hr />
                {pdvs.length > 0 ? 
                    <section className="row">
                        <div className="col-md-12">
                            <table className='table'>
                                <tbody>,
                                    {pdvs.map((pdv: PDV, ii: number) => {
                                        return <tr key={ii}>
                                            <td>{pdv.adresse}<br />{pdv.postalcode} {pdv.city} </td>
                                            <td></td> 
                                            <td></td>
                                            <td>
                                                <ul>
                                                    {pdv.datas.prix.map((price: PDV_PRICE, jj: number) => {
                                                        return <li key={jj}
                                                                className='d-flex justify-content-between'
                                                            ><strong>{price.nom}</strong><span>{price.valeur}</span></li>
                                                    })}
                                                </ul>
                                            </td>
                                        </tr>
                                    })}
                                </tbody>
                            </table>
                        </div>
                    </section>
                    : null 
                }
            </>  
        ) 
    }
}
export default Default;