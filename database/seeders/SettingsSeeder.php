<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $agreementBody = '
<h2>Car Rental Agreement (Australia)</h2>
<p><strong>Additional Terms – Perth Region Conditions</strong></p>

<h3>4. Vehicle Use Area Limitation (Important)</h3>
<p>This vehicle is authorised to operate ONLY within a 200 KM radius of Perth CBD, Western Australia. Use of the vehicle outside this boundary without written permission from the Owner is strictly prohibited. Any breach may lead to immediate termination of the rental agreement and repossession of the vehicle.</p>

<h3>5. Vehicle Maintenance &amp; Service Responsibility</h3>
<p>The Renter/Driver is responsible for ensuring the vehicle is serviced on time. If a service is due or any warning light or mechanical issue appears, the Renter must stop driving immediately and contact the Owner to take the vehicle to the Owner\'s nominated mechanic. Failure to do so may result in full liability for any further mechanical damage.</p>

<h3>6. Vehicle Return Notice Period</h3>
<p>The Renter must provide a minimum of two (2) week\'s written notice before returning the vehicle. Failure to provide this notice may result in additional rental charges equal to two weeks of rent or loss of bond, at the Owner\'s discretion.</p>

<h3>7. Terms and Conditions</h3>
<p>7.1 This is giving us the right to report the vehicle as stolen if you do not return the vehicle on time, or if you engage in any misbehaviour, or if you fail to return the vehicle when requested by us.</p>
<p>7.2 Failure to return the vehicle when requested will be considered a serious breach of agreement.</p>
<p>7.3 Any misbehaviour, abuse, or inappropriate conduct toward the owner, staff, or representatives will result in immediate termination of the agreement and recovery of the vehicle.</p>
<p>7.4 Failure to make rental payments on time will be treated as a breach of agreement, and the vehicle may be recovered immediately through POLICE.</p>
<p>7.5 The renter is fully responsible for any damage caused to the rental vehicle, any personal injury, third parties injuries or any third-party property damage during the rental period.</p>
<p>7.6 If the renter does not return the vehicle when requested, or refuses to hand it back in any situation, the company will report the vehicle as STOLEN to the POLICE.</p>
<p>7.7 If the vehicle is not returned immediately when demanded, and the renter does not cooperate in any way, the company will report it to the POLICE as a STOLEN VEHICLE.</p>
<p>7.8 The company has the right to recover or repossess the vehicle immediately in case of violation of any terms mentioned above.</p>

<h3>8. Car Insurance Excess Agreement (Australia)</h3>
<p>This section outlines the insurance excess responsibilities under the commercial vehicle insurance policy. Both the Owner and the Driver/Renter must read and understand this agreement before signing.</p>
<p><strong>Insurance Details:</strong> Type of Insurance: Commercial Comprehensive. Policy Excess: AUD $2,000 per incident.</p>
<p>8.1 The Owner confirms that the vehicle is insured under a valid commercial comprehensive insurance policy.</p>
<p>8.2 In the event of an accident where the Renter is at fault, an excess of AUD $2,000 applies. The Renter must pay this directly to the Owner or insurer.</p>
<p>8.3 If the vehicle is involved in a hit-and-run accident where the other party cannot be identified, the Renter is still liable to pay the AUD $2,000 excess.</p>
<p>8.4 The same AUD $2,000 excess applies whether the Renter is at fault or not, if the third-party driver cannot be identified or located.</p>
<p>8.5 The Renter must immediately report any accident, collision, theft, or damage to the Owner and to the nearest police station, providing a police report number.</p>
<p>8.6 24-Hour Accident Reporting: The Renter must inform the Owner and/or insurance company within 24 hours of any accident. Failure to report within 24 hours may void the insurance and make the Renter fully liable for all damages.</p>
<p>8.7 Failure to provide a valid police report for a hit-and-run incident may result in full repair costs being charged to the Renter.</p>
<p>8.8 The Renter must not admit fault or negotiate with any third party without the Owner\'s written consent.</p>
<p>8.9 Any excess paid by the Renter may be refunded if the insurer later recovers the cost from another party.</p>
<p>8.10 If damages exceed policy coverage or result from a breach of rental terms (e.g., drunk driving, unlisted driver, illegal activity), the Renter will be fully liable for all repair and related costs.</p>
<p>8.11 This Agreement is governed by the laws of Western Australia.</p>
<p><strong>Acknowledgement:</strong> I, the undersigned Renter/Driver, acknowledge that I have read, understood, and agree to the insurance excess terms above. I understand that I must pay AUD $2,000 excess in the event of an accident or a hit-and-run where the other party cannot be identified. I also understand that I must report any accident within 24 hours, otherwise insurance cover may be void.</p>

<h3>9. Towing / Breakdown Procedure</h3>
<p>9.1 In the event of a breakdown, accident, or mechanical failure, the Renter MUST contact and use the Owner\'s nominated towing company.</p>
<p>9.2 The Renter must NOT arrange or authorise towing or recovery with any other company or mechanic without prior written permission from the Owner.</p>
<p>9.3 If the Renter arranges alternative towing without the Owner\'s written permission, the Owner will NOT be liable to pay or reimburse those costs. The Renter will be solely responsible for all charges incurred.</p>
<p>9.4 The Owner reserves the right to require the vehicle to be taken to the Owner\'s approved mechanic for inspection and repair.</p>
<p>9.5 If the Renter takes the vehicle to an unapproved mechanic without the Owner\'s consent, the Owner may refuse to accept the vehicle until inspected by the Owner\'s mechanic, and the Renter may be liable for additional costs.</p>
<p>9.6 Temporary roadside repairs by an unauthorised provider are not accepted as final repairs. The Owner may require the vehicle be returned to the approved repairer for a full inspection.</p>
<p>9.7 The Renter agrees to pay any towing, storage, repair, or related costs if they fail to follow this procedure, unless otherwise agreed in writing by the Owner.</p>
<p><strong>Acknowledgement (Towing &amp; Breakdown Procedure):</strong> I, the Renter/Driver, acknowledge that I have read, understood and agree to comply with the Towing / Breakdown Procedure above. I understand that failure to use the Owner\'s nominated towing company may result in the Owner refusing to cover costs and I will be liable for any charges.</p>

<h3>10. Car Cleaning Agreement (Australia)</h3>
<p>10.1 The vehicle is provided to the Renter/Driver in a clean condition, both exterior and interior, at the start of the rental period.</p>
<p>10.2 The Renter agrees to return the vehicle in the same clean condition as received.</p>
<p>10.3 If the vehicle is returned dirty or with excessive dirt, sand, stains, rubbish, or strong odours, cleaning charges will apply: Sedan or Small Car: AUD $80 | SUV or 4WD: AUD $120.</p>
<p>10.4 The Owner reserves the right to determine the level of cleaning required based on the vehicle\'s condition upon return.</p>
<p>10.5 Cleaning fees will be deducted from the Renter\'s bond or charged directly if the bond is insufficient.</p>
<p>10.6 Returning a vehicle in an unclean condition may delay the bond refund until the vehicle is inspected and cleaned.</p>
<p>10.7 Normal dust or light exterior dirt from standard driving will not attract cleaning charges, but mud, sand, food, drink spills, or stains will.</p>
<p>10.8 In case of disputes about cleanliness, the Owner\'s inspection and photographic evidence will be considered final.</p>
<p>10.9 The Renter agrees not to use any cleaning chemicals, sprays, or external car wash services without the Owner\'s consent.</p>
<p>10.10 This agreement is governed by the laws of Western Australia.</p>
<p><strong>Acknowledgement:</strong> I, the undersigned Driver/Renter, acknowledge that I have received the vehicle in a clean condition and agree to return it in the same condition. I understand that if the vehicle is returned dirty, the applicable cleaning fee ($80 for sedan / $120 for 4WD) will be deducted from my bond or charged directly.</p>

<h3>11. Personal Detail Update &amp; Communication Agreement (Australia)</h3>
<p>11.1 All contact details provided by the Renter/Driver are correct and current at the time of signing.</p>
<p>11.2 The Renter/Driver must notify the Owner immediately if there are any changes to their phone number, email, or residential address.</p>
<p>11.3 The Owner will use the Renter\'s contact details for all official communication including fines, notices, penalties, invoices, and other legal or business matters.</p>
<p>11.4 Any notice or correspondence sent to the Renter\'s provided contact details will be deemed as legally delivered and acknowledged by the Renter.</p>
<p>11.5 It is the Renter\'s responsibility to ensure all contact details remain active and accessible throughout the rental period.</p>
<p>11.6 Failure to update personal details or respond to official communication may result in additional administrative fees or legal action.</p>
<p>11.7 The Owner is not responsible for any missed communication, fines, or legal notices if sent to the Renter\'s provided contact information.</p>
<p>11.8 This Agreement remains valid and enforceable as part of the main Car Rental Agreement.</p>
<p>11.9 This Agreement is governed by the laws of Western Australia.</p>
<p><strong>Acknowledgement:</strong> I, the undersigned Renter/Driver, acknowledge that I have provided accurate and up-to-date contact details and agree to the communication clauses above.</p>

<h3>12. Contract Termination &amp; Repossession Agreement (Australia)</h3>
<p>This Agreement sets out the Owner\'s rights to terminate the Car Rental Agreement and repossess the vehicle where the Renter/Driver breaches the rental terms.</p>
<p>12.1 The Owner reserves the right to terminate the agreement and repossess the vehicle immediately, without prior notice, in the following circumstances:</p>
<ol type="a">
<li>Failure to pay the bond or any part of the bond by the agreed time.</li>
<li>Failure to pay weekly rent or any agreed rental instalment on time.</li>
<li>Repeated or reckless driving that endangers the vehicle, occupants, or public safety.</li>
<li>Any deliberate or negligent damage to the vehicle.</li>
<li>Intentional damage to public property or involvement in illegal activities while using the vehicle.</li>
<li>Failure to return the vehicle at the agreed time or location, or attempted concealment of the vehicle.</li>
<li>Use of the vehicle by any unapproved driver, or use for unauthorised commercial activities.</li>
</ol>
<p>12.2 If the Owner exercises the right to repossess the vehicle, the Renter acknowledges that the Owner (or its authorised agents) may enter the premises where the vehicle is believed to be located and recover it.</p>
<p>12.3 Any costs associated with repossession, towing, storage, and recovery caused by the Renter\'s breach will be payable by the Renter.</p>
<p>12.4 If the Renter fails to return the vehicle or the Owner reasonably suspects criminal behaviour, the Owner may report the matter to the police.</p>
<p>12.5 Termination and repossession do not waive the Owner\'s right to recover any outstanding amounts, repair costs, cleaning fees, fines, or other losses.</p>
<p>12.6 The Owner may terminate the agreement for any other material breach of the rental terms.</p>
<p>12.7 The Owner\'s exercise of termination or repossession rights is subject to applicable laws in Western Australia.</p>
<p>12.8 This Agreement is governed by the laws of Western Australia.</p>
<p><strong>Acknowledgement:</strong> I, the undersigned Renter/Driver, acknowledge that I have read and understood the Termination &amp; Repossession clauses above. I agree that the Owner may terminate the rental agreement and repossess the vehicle in the circumstances described, and that I remain liable for any costs and losses arising from my breach.</p>

<h3>13. Accident Procedure &amp; Insurance Agreement</h3>
<p>13.1 In the event of any accident, the driver must immediately collect the following information from the other party: full name, valid driving licence number, a copy or photo of the licence, contact number, and current residential address.</p>
<p>13.2 The driver must record complete accident details including the exact date and time, the precise location or road name, and a short description of how the accident occurred.</p>
<p>13.3 Photographic evidence must be taken whenever possible, including photos of both vehicles, licence plates, the surrounding area, and any visible damage.</p>
<p>13.4 The driver must immediately inform the Owner and share all collected information and evidence as requested.</p>
<p>13.5 The driver must cooperate fully with the insurance company and provide any additional information or documentation required during the claim process.</p>
<p>13.6 The driver is responsible for paying the insurance excess required to initiate the claim process.</p>
<p>13.7 The excess amount must be paid regardless of whether the third party is at fault at the time of filing the claim.</p>
<p>13.8 If the insurance investigation later determines that the third party was at fault, the excess amount may be refunded according to the insurance company\'s policy.</p>
<p>13.9 Failure to provide required accident details, documents, or cooperation may result in the driver being fully responsible for all repair costs or damages.</p>
<p>13.10 Any traffic fines, violations, or penalties occurring during vehicle use remain the sole responsibility of the driver.</p>
<p>13.11 The driver agrees to operate the vehicle responsibly and follow all traffic laws and safety regulations at all times.</p>
<p>13.12 Any misuse, reckless driving, driving under the influence, or illegal activity may void insurance coverage and make the driver fully liable for all damages.</p>

<h3>14. Breakdown Waiting Obligation &amp; Liability Agreement</h3>
<p>14.1 In the event of a breakdown, mechanical failure, accident, or any situation that renders the vehicle undriveable or unsafe, the Renter/Driver must remain with the vehicle at all times until authorised assistance arrives.</p>
<p>14.2 The Renter/Driver is strictly prohibited from leaving the vehicle unattended on a public road, highway, car park, or any location where it may cause a hazard, obstruction, or be subject to government impoundment or towing.</p>
<p>14.3 The Renter/Driver must immediately contact the Owner and the Owner\'s nominated towing company (as specified in Section 9) and wait for their arrival before leaving the vehicle.</p>
<p>14.4 Government Impoundment Liability: If the Renter/Driver abandons the vehicle and any government authority tows or impounds it, all fines, impoundment fees, storage charges, and towing costs will be solely the responsibility of the Renter/Driver.</p>
<p>14.5 If the abandoned vehicle causes any damage, obstruction, or hazard to other road users or property, the Renter/Driver will be held fully legally and financially responsible for all resulting damages, fines, or legal proceedings.</p>
<p>14.6 Abandoning the vehicle without the Owner\'s written consent is a material breach of this Agreement and may result in immediate termination of the rental agreement, repossession of the vehicle, and forfeiture of the bond.</p>
<p>14.7 This Agreement is governed by the laws of Western Australia.</p>
<p>14.8 Towing is limited to a maximum distance of 25 km; any additional distance or cost beyond this limit must be paid by the driver.</p>
<p><strong>Acknowledgement:</strong> I, the undersigned Renter/Driver, acknowledge that I have read and fully understood the Breakdown Waiting Obligation &amp; Liability Agreement above. I understand that I must remain with the vehicle in the event of a breakdown and wait for authorised assistance. I accept full legal and financial responsibility for any fines, impoundment fees, damages, or penalties arising from my failure to comply.</p>

<h3>15. Minor Damage, Uninsured Damage &amp; Driver Liability</h3>
<p>15.1 The driver is responsible for any small damage to the vehicle during the rental period. This includes dents, scratches, marks, side mirror damage, broken mirrors, cracked or broken windscreen, and any damage caused by another person or vehicle hitting the car.</p>
<p>15.2 Tyre damage such as punctures, blowouts, cuts, or damage to wheels is not covered by insurance. The driver must pay the full cost to repair or replace the tyre.</p>
<p>15.3 Any internal or mechanical damage caused by misuse, carelessness, or not following maintenance rules in Section 5 is not covered by insurance. The driver must pay for it.</p>
<p>15.4 If someone else damages the vehicle while it is parked or with the driver and that person cannot be identified, the driver must pay all repair costs along with any insurance excess mentioned in Section 8.</p>
<p>15.5 If any damage happens, the driver must immediately inform the owner with full details, take photos of the damage before moving the vehicle if it is safe, and collect the other person\'s name, licence number, contact number, and address if another person was involved. If the driver does not collect these details, they will be fully responsible for all repair costs and related expenses even if it was not their fault.</p>
<p><strong>Acknowledgement:</strong> I, the undersigned Renter/Driver, acknowledge that I have read and understood Section 15 and accept full financial responsibility for any minor, cosmetic, tyre-related, or uninsured damage that occurs during the rental period.</p>

<h3>16. Vehicle Walkaround Worksheet</h3>
<p>The driver confirms they have inspected the vehicle at the time of pickup and agree to the condition noted below.</p>

<h3>Important Notice to Renter/Driver</h3>
<p><strong>PLEASE READ THE FOLLOWING TERMS CAREFULLY BEFORE SIGNING. THESE TERMS ARE LEGALLY BINDING AND WILL BE STRICTLY ENFORCED.</strong></p>
<ol>
<li>If the driver does not pay rent on time or uses the car for illegal activity, the owner will report it to the police immediately and the car will be treated as stolen.</li>
<li>In case of an accident, the driver must collect full details of the other person and take photos, and inform the owner immediately or they will have to pay all costs themselves.</li>
<li>If the car is fined, towed, or impounded during the rental, the driver must pay all related costs and fines.</li>
<li>The driver must stay in contact with the owner at all times. Ignoring messages can lead to the car being taken back and reported as stolen.</li>
</ol>

<h3>Final Acknowledgement</h3>
<p>By signing below, the Renter/Driver acknowledges that they have read, understood, and agreed to all sections of this Agreement, including Additional Perth Terms, Main Terms &amp; Conditions, Insurance Excess, Towing/Breakdown, Cleaning, Personal Detail &amp; Communication, Contract Termination &amp; Repossession, Minor Damage &amp; Driver Liability, Breakdown Waiting Obligation &amp; Liability, Important Notice, and Vehicle Walkaround Worksheet. This Agreement is governed by the laws of Western Australia.</p>
';

        $rows = [
            ['key' => 'agreement_body',       'value' => $agreementBody],
            ['key' => 'owner_email',          'value' => 'faisal@carrentalperth.com'],
            ['key' => 'admin_email',          'value' => 'admin@carrentalperth.com'],
            ['key' => 'owner_name',           'value' => 'Faisal Rasheed'],
            ['key' => 'company_name',         'value' => 'Faisal Car Rentals Perth'],
            ['key' => 'company_address',       'value' => '58 Royal Street, Tuart Hill, Perth WA'],
            ['key' => 'company_phone',         'value' => '0424 022 786'],
            ['key' => 'owner_signature_path', 'value' => 'private/signatures/owner_signature.png'],
        ];

        foreach ($rows as $row) {
            Setting::updateOrCreate(['key' => $row['key']], ['value' => $row['value']]);
        }
    }
}
