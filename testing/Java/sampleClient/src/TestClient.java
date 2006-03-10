import java.net.MalformedURLException;
import java.net.URL;
import java.rmi.RemoteException;

import javax.xml.rpc.ServiceException;

import org.apache.axis.EngineConfiguration;
import org.apache.axis.client.Stub;
import org.apache.axis.configuration.FileProvider;
import org.apache.ws.security.WSConstants;
import org.apache.ws.security.handler.WSHandlerConstants;
import org.apache.ws.security.message.token.UsernameToken;

import de.tele_task.model.Lecture;
import de.tele_task.services.TeleTaskServiceLocator;
import de.tele_task.services.TeleTaskServiceSoap;

/**
 * 
 */

/**
 * @author GRon
 *
 */
public class TestClient {
	public static void main(String[] args) {
		EngineConfiguration cfg = new FileProvider("axis.wsdd");
		TeleTaskServiceLocator locator = new TeleTaskServiceLocator(cfg);
		try {
			URL url = new URL("http://localhost:2222/webp/repo/source/soap.php");
			TeleTaskServiceSoap stub = locator.getTeleTaskServiceSoap(url);
			Stub axisPort = (Stub)stub;
			axisPort._setProperty(UsernameToken.PASSWORD_TYPE, WSConstants.PW_DIGEST);
			axisPort._setProperty(WSHandlerConstants.PW_CALLBACK_REF, new PWCallback());
			axisPort._setProperty(WSHandlerConstants.USER, "Micha");
			PWCallback.setLogin("Micha", "HPI");
			try {
				//Lecture[] lectures = stub.getAllLectures();
				Lecture l = stub.getLecture(106);
				System.out.println(l.getId());
				System.out.println(l.getName());
				Lecture[] lectures = stub.getAllLectures();
				//System.out.println(lectures);
				for (Lecture lecture : lectures) {
					System.out.println(lecture.getName());
				}

				//System.out.println(lectures);
			} catch (RemoteException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		} catch (ServiceException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (MalformedURLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
}
