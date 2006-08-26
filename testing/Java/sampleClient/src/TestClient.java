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

import org.example.queryLecture.*;

public class TestClient {
	public static void main(String[] args) {
		EngineConfiguration cfg = new FileProvider("axis.wsdd");
		QueryLectureLocator locator = new QueryLectureLocator(cfg);
		try {
			URL url = new URL("http://localhost:8080/webp/repo/example/teletask/soap.php/queryLecture");
			QueryLecturePortType stub = locator.getqueryLecturePort(url);
			Stub axisPort = (Stub)stub;
			axisPort._setProperty(UsernameToken.PASSWORD_TYPE, WSConstants.PW_DIGEST);
			axisPort._setProperty(WSHandlerConstants.PW_CALLBACK_REF, new PWCallback());
			axisPort._setProperty(WSHandlerConstants.USER, "Stefan");
			PWCallback.setLogin("Stefan", "HPI");
			try {
				//Lecture[] lectures = stub.getAllLectures();
				System.out.println("getLecture(106)");
				Lecture l = stub.getLecture(106);
				System.out.print("LectureId: ");
				System.out.println(l.getId());
				System.out.print("LectureName: ");
				System.out.println(l.getName());
				System.out.println();
				System.out.println("getAllLectures()");
				Lecture[] lectures = stub.getAllLectures();
				//System.out.println(lectures);
				for (Lecture lecture : lectures) {
					System.out.print("LectureName: ");
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
